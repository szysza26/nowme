<?php


class PayU
{
    private $posId;
    private $md5;
    private $clientId;
    private $clientSecret;

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
}