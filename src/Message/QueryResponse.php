<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Message\AbstractResponse;

class QueryResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        $data = $this->getData();

        return isset($data['txn']['result_code']) && $data['txn']['result_code'] === "200";
    }

    public function isPending(): bool
    {
        return true;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function isTransparentRedirect(): bool
    {
        return true;
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}