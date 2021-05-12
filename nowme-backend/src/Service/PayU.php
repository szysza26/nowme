<?php


class PayU
{
    public function __contruct()
    {
        //set Sandbox Environment
        OpenPayU_Configuration::setEnvironment('sandbox');

        //set POS ID and Second MD5 Key (from merchant admin panel)
        OpenPayU_Configuration::setMerchantPosId('405103');
        OpenPayU_Configuration::setSignatureKey('f149ce0f12ee34cfc1c02e1e3e517097');

        //set Oauth Client Id and Oauth Client Secret (from merchant admin panel)
        OpenPayU_Configuration::setOauthClientId('405103');
        OpenPayU_Configuration::setOauthClientSecret('8f33ea0dd3a4ddae44ba302e6da8b83d');
    }

    public function create(\NowMe\Entity\Reservation $reservation)
    {
        $order['continueUrl'] = 'http://localhost/'; //TODO do uzupełnienia
        $order['notifyUrl'] = 'http://localhost/'; //TODO do uzupełnienia
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'New order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = $reservation->getService()->getPrice();
        $order['extOrderId'] = $reservation->getId();

        $order['products'][0]['name'] = $reservation->getService()->getName();
        $order['products'][0]['unitPrice'] = $reservation->getService()->getPrice();
        $order['products'][0]['quantity'] = 1;

        //optional section buyer
        $order['buyer']['email'] = $reservation->getUser()->getEmail();
        $order['buyer']['phone'] = '123123123';
        $order['buyer']['firstName'] = $reservation->getUser()->firstName();
        $order['buyer']['lastName'] = $reservation->getUser()->lastName();

        $response = OpenPayU_Order::create($order);

        header('Location:'. $response->getResponse()->redirectUri);
    }
}