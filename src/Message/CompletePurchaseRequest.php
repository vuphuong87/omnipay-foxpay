<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData(): array
    {
        $order     = $this->httpRequest->request->all();
        $signature = $order['signature'];

        // remove it before compute signature
        unset($order['signature']);

        $order['computed_signature'] = $this->computeSignature(
            implode('', array_values($order))
        );

        // add back
        $order['signature'] = $signature;

        return $order;
    }

    public function sendData($data): CompletePurchaseResponse
    {
        return new CompletePurchaseResponse($this, $data);
    }
}