<?php

declare(strict_types=1);

namespace Omnipay\Foxpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Foxpay\Message\PurchaseRequest;
use Omnipay\Foxpay\Message\QueryRequest;
use Omnipay\Foxpay\Message\CompletePurchaseRequest;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Foxpay';
    }

    public function getDefaultParameters(): array
    {
        return [
            'version'    => '',
            'merchantId' => '',
            'terminalId' => '',
            'signature'  => '',
            'secretKey'  => '',
        ];
    }

    public function getVersion(): string
    {
        return $this->getParameter('version');
    }

    public function setVersion(string $version): self
    {
        return $this->setParameter('version', $version);
    }

    public function getReturnToken(): bool
    {
        return $this->getParameter('returnToken');
    }

    public function setReturnToken(bool $returnToken): self
    {
        return $this->setParameter('returnToken', $returnToken);
    }

    public function getMerchantId(): string
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId(string $merchantId): self
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    public function getTerminalId(): string
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId(string $terminalId): self
    {
        return $this->setParameter('terminalId', $terminalId);
    }

    public function getSignature(): string
    {
        return $this->getParameter('signature');
    }

    public function setSignature(string $signature): self
    {
        return $this->setParameter('signature', $signature);
    }

    public function getSecretKey(): string
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey(string $secretKey): self
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    public function purchase(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function query(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(QueryRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

}