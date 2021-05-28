<?php

namespace NowMe\Service;

use Doctrine\Persistence\ManagerRegistry;
use NowMe\Entity\Payment;
use NowMe\Entity\Reservation;
use NowMe\Event\PaymentWasRefunded;
use NowMe\Event\ReservationWasCanceled;
use NowMe\Event\ReservationWasPaid;
use NowMe\Repository\PaymentRepository;
use OpenPayU_Configuration;
use OpenPayU_Order;
use OpenPayU_Refund;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class PayU
{
    private PaymentRepository $paymentRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(PaymentRepository $paymentRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->paymentRepository = $paymentRepository;
        $this->eventDispatcher = $eventDispatcher;
        //set Sandbox Environment
        OpenPayU_Configuration::setEnvironment('sandbox');

        //set POS ID and Second MD5 Key (from merchant admin panel)
        OpenPayU_Configuration::setMerchantPosId('405103');
        OpenPayU_Configuration::setSignatureKey('f149ce0f12ee34cfc1c02e1e3e517097');

        //set Oauth Client Id and Oauth Client Secret (from merchant admin panel)
        OpenPayU_Configuration::setOauthClientId('405103');
        OpenPayU_Configuration::setOauthClientSecret('8f33ea0dd3a4ddae44ba302e6da8b83d');
    }

    public function create(Reservation $reservation): string
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

        $response = OpenPayU_Order::create($order);
        $payment = new Payment();
        $payment
            ->setOrderId($response->getResponse()->orderId)
            ->setReservationId($reservation)
            ->setStatus(Payment::STATUS_ADD)
            ->setDateCreate(new \DateTime());

        $this->paymentRepository->save($payment);
        return $response->getResponse()->redirectUri;
    }

    public function refund($orderId): void
    {
        $refund = OpenPayU_Refund::create(
            $orderId,
            'Zwrot kaucji'
        );

        if ($refund->getStatus() !== 'SUCCESS') {
            return;
        }

        $payment = $this->paymentRepository->getByOrderId($orderId);
        $payment->setStatus(Payment::STATUS_REFUND);
        $this->paymentRepository->save($payment);
        $this->eventDispatcher->dispatch(new PaymentWasRefunded($payment->getId()));
    }

    public function notify(Payment $payment): void
    {
        $response = OpenPayU_Order::retrieve($payment->getOrderId());

        if ($response->getStatus() !== 'SUCCESS') {
            return;
        }

        $order = $response->getResponse()->orders[0];

        switch ($order->status) {
            case 'COMPLETED':
                $this->markAsPaid($payment);
                break;
            case 'CANCELED':
                $this->markAsCanceled($payment);
                break;
            default:
                $diff = $payment->getDateCreate()->diff(new \DateTime());
                if ($diff->i > 30) {
                    $this->markAsCanceled($payment);
                }
        }
    }

    private function markAsPaid(Payment $payment): void
    {
        $payment->setStatus(Payment::STATUS_PAID);
        $this->eventDispatcher->dispatch(new ReservationWasPaid((int)$payment->getOrderId(), $payment->getId()));
    }

    private function markAsCanceled(Payment $payment): void
    {
        $payment->setStatus(Payment::STATUS_CANCEL);
        $this->eventDispatcher->dispatch(new ReservationWasCanceled((int)$payment->getOrderId(), $payment->getId()));
    }
}