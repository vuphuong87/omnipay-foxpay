<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends AbstractResponse
{
    public const RESPONSE_STATUS_SUCCESS = 1;
    public const RESPONSE_STATUS_FAIL    = 2;
    public const RESPONSE_STATUS_CANCEL  = 3;
    public const RESPONSE_STATUS_PENDING = 4;

    private $responseStatus;
    private $message;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->handleResponse($data);
    }

    public function isPending(): bool
    {
        return $this->responseStatus === self::RESPONSE_STATUS_PENDING;
    }

    public function isSuccessful(): bool
    {
        return $this->responseStatus === self::RESPONSE_STATUS_SUCCESS;
    }

    public function isCancelled(): bool
    {
        return $this->responseStatus === self::RESPONSE_STATUS_CANCEL;
    }

    public function isSignatureVerified(array $data): bool
    {
        return strtoupper($data['signature']) === strtoupper($data['computed_signature']);
    }

    public function getTransactionId()
    {
        if (! $this->isSuccessful()) {
            return null;
        }

        return $this->data['order_no'] ?? null;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    private function handleResponse($data): void
    {
        if ($this->isSignatureVerified($data) === false) {
            $this->message        = 'The signatures do not match';
            $this->responseStatus = self::RESPONSE_STATUS_FAIL;

            return;
        }

        switch ($data['result_code']) {
            case '100':
                $this->responseStatus = self::RESPONSE_STATUS_PENDING;
                $this->message        = 'Partner order is pending.';
                break;
            case '200':
                $this->responseStatus = self::RESPONSE_STATUS_SUCCESS;
                $this->message        = 'Partner order has been paid.';
                break;
            case '513':
                $this->responseStatus = self::RESPONSE_STATUS_CANCEL;
                $this->message        = 'Partner order has been cancelled.';
                break;
            default:
                $this->responseStatus = self::RESPONSE_STATUS_FAIL;
                $this->message        = 'Unspecified issue occurred';
                break;
        }
    }
}