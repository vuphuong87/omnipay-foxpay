<?php

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    public function getCurrency()
    {
        // only works for VND
        return 'VND';
    }

    public function getVersion()
    {
        return $this->getParameter('version');
    }

    public function setVersion($version)
    {
        return $this->setParameter('version', $version);
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

    public function setValidityTime($validityTime)
    {
        return $this->setParameter('validityTime', $validityTime);
    }

    public function getValidityTime()
    {
        return $this->getParameter('validityTime');
    }

    public function getEndpoint() {
        $endpoint = 'https://portal.foxpay.vn/payment/checkout';
        if ($this->getTestMode())
            $endpoint = 'https://portal-staging.foxpay.vn/payment/checkout';

        return $endpoint;
    }
}