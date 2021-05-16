<?php

namespace NowMe\Service;
use Doctrine\Persistence\ManagerRegistry;
use NowMe\Entity\Payment;
use NowMe\Repository\PaymentRepository;
use OpenPayU_Configuration;
use OpenPayU_Order;
use OpenPayU_Refund;

class PayU
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
        //set Sandbox Environment
        OpenPayU_Configuration::setEnvironment('sandbox');

        //set POS ID and Second MD5 Key (from merchant admin panel)
        OpenPayU_Configuration::setMerchantPosId('405103');
        OpenPayU_Configuration::setSignatureKey('f149ce0f12ee34cfc1c02e1e3e517097');

        //set Oauth Client Id and Oauth Client Secret (from merchant admin panel)
        OpenPayU_Configuration::setOauthClientId('405103');
        OpenPayU_Configuration::setOauthClientSecret('8f33ea0dd3a4ddae44ba302e6da8b83d');
    }

    public function create(\NowMe\Entity\Reservation $reservation): string
    {
        $order = [];
        $order['continueUrl'] = 'http://localhost:3000/reservations/list';
        $order['notifyUrl'] = 'http://localhost:3000/reservations/list';
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'New order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = $reservation->getService()->getPrice() * 100;
        $order['extOrderId'] = $reservation->getId();

        $order['products'][0]['name'] = $reservation->getService()->getName()->name();
        $order['products'][0]['unitPrice'] = $reservation->getService()->getPrice() * 100;
        $order['products'][0]['quantity'] = 1;

        //optional section buyer
        $order['buyer']['email'] = $reservation->getUser()->getEmail();
        $order['buyer']['phone'] = '123123123';
        $order['buyer']['firstName'] = $reservation->getUser()->firstName();
        $order['buyer']['lastName'] = $reservation->getUser()->lastName();

        //dd($order);

        $response = OpenPayU_Order::create($order);
        $payment = new \NowMe\Entity\Payment();
        $payment
            ->setOrderId($response->getResponse()->orderId)
            ->setReservationId($reservation)
            ->setStatus(\NowMe\Entity\Payment::STATUS_ADD)
            ->setDateCreate(new \DateTime());
        $this->paymentRepository->save($payment);

        return $response->getResponse()->redirectUri;
    }

    public function refund($orderId)
    {
        $refund = OpenPayU_Refund::create(
            $orderId,
            'Zwrot kaucji'
        );
        if($refund->getStatus() == 'SUCCESS'){
            $payment = $this->paymentRepository->getByOrderId($orderId);
            $payment->setStatus(\NowMe\Entity\Payment::STATUS_REFUND);
            $this->paymentRepository->save($payment);
        }
    }

    public function notify(\NowMe\Entity\Payment &$payment)
    {
        $response = OpenPayU_Order::retrieve($payment->getOrderId());
        if($response->getStatus() == 'SUCCESS') {
            $order = $response->getResponse()->orders[0];
            switch ($order->status) {
                case 'COMPLETED':
                    $payment->setStatus(\NowMe\Entity\Payment::STATUS_PAID);
                    break;
                case 'CANCELED':
                    $payment->setStatus(\NowMe\Entity\Payment::STATUS_CANCEL);
                    break;
                default:
                    $diff = $payment->getDateCreate()->diff(new \DateTime());
                    if ($diff->i > 30) {
                        $payment->setStatus(\NowMe\Entity\Payment::STATUS_CANCEL);
                    }
            }
        }
    }
}