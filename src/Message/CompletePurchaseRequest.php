<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData(): array
    {
        $request = $this->httpRequest->request->all();

        $order = [
            'version'        => $request['version'] ?? null,
            'transaction_id' => $request['transaction_id'] ?? null,
            'merchant_id'    => $request['merchant_id'] ?? null,
            'terminal_id'    => $request['terminal_id'] ?? null,
            'payment_method' => $request['payment_method'] ?? null,
            'order_id'       => $request['order_id'] ?? null,
            'amount'         => $request['amount'] ?? null,
            'currency'       => $request['currency'] ?? null,
            'brand_card'     => $request['brand_card'] ?? null,
            'issue_place'    => $request['issue_place'] ?? null,
            'result_code'    => $request['result_code'] ?? null,
            'result'         => $request['result'] ?? null,
            'message'        => $request['message'] ?? null,
            'url_bill'       => $request['url_bill'] ?? null,
            'token_schema'   => $request['token_schema'] ?? null,
            'token_brand'    => $request['token_brand'] ?? null,
            'token_number'   => $request['token_number'] ?? null,
            'token'          => $request['token'] ?? null,
            'signature'      => $request['signature'] ?? null,
        ];

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