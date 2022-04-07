<?php

namespace Omnipay\Foxpay;


use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Foxpay';
    }

    public function getDefaultParameters()
    {
        return [
            'version'       => '',
            'merchantId'    => '',
            'terminalId'    => '',
            'signature'     => '',
            'secretKey'     => ''
        ];
    }

    public function getVersion()
    {
        return $this->getParameter('version');
    }

    public function setVersion($version)
    {
        return $this->setParameter('version', $version);
    }

    public function getReturnToken()
    {
        return $this->getParameter('returnToken');
    }

    public function setReturnToken($returnToken)
    {
        return $this->setParameter('returnToken', $returnToken);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($terminalId)
    {
        return $this->setParameter('terminalId', $terminalId);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($signature)
    {
        return $this->setParameter('signature', $signature);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Foxpay\Message\PurchaseRequest', $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Foxpay\Message\QueryRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Foxpay\Message\CompletePurchaseRequest', $parameters);
    }

}