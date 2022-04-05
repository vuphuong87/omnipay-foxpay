<?php

namespace Omnipay\Foxpay\Message;


class CompletePurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        return [
            'order_no' => $this->httpRequest->request->get('order_id'),
            'state' => $this->httpRequest->request->get('result_code'),
            'signature' => $this->httpRequest->request->get('signature'),
            'computed_checksum' => $this->computedSignature($this->httpRequest->request->all()),
            'method' => 'post',
            'payment_method' => $this->httpRequest->request->get('payment_method')
        ];
    }

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }

    private function computedSignature($data)
    {
        $rawHash = '';
        foreach ($data as $key => $value) {
            if($value) {
                $rawHash .= $value;
            }
        }

        return hash('sha256', $rawHash.$this->getSecretKey());
    }
}