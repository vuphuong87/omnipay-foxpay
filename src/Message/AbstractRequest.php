<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

use function Symfony\Component\String\s;

abstract class AbstractRequest extends BaseAbstractRequest
{
    public function getCurrency(): string
    {
        return 'VND';
    }

    public function getVersion(): string
    {
        return $this->getParameter('version');
    }

    public function setVersion(string $version): self
    {
        return $this->setParameter('version', $version);
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

    public function getReturnToken(): bool
    {
        return $this->getParameter('returnToken');
    }

    public function setReturnToken(bool $returnToken): self
    {
        return $this->setParameter('returnToken', $returnToken);
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

    public function getEndpoint(): string
    {
        $endpoint = 'https://portal.foxpay.vn';
        if ($this->getTestMode()) {
            $endpoint = 'https://portal-staging.foxpay.vn';
        }

        return $endpoint;
    }

    protected function calculateSignature(string $rawHash): string
    {
        return hash('sha256', $rawHash . $this->getSecretKey());
    }

    protected function buildOrder(array $data): array
    {
        $order = [];
        array_walk($data, static function ($value, $key) use (&$order) {
            $key         = s($key)->snake()->toString();
            $order[$key] = $value;
        });

        return $order;
    }
}