<?php

namespace Omnipay\Foxpay\Message;

use Cake\Chronos\Chronos;
use Omnipay\Common\Exception\InvalidRequestException;

class QueryRequest extends AbstractRequest
{
    const TIME_ZONE = 'Asia/Ho_Chi_Minh';
    private $endPointProduction = 'https://portal.foxpay.vn';
    private $endPointSandbox = 'https://portal-staging.foxpay.vn';

    public function getData()
    {
        $this->validate(
            'version',
            'merchantId',
            'terminalId',
            'orderId'
        );

        $order = $this->buildOrder();

        $secretKey = $this->getSecretKey();

        $rawHash = '';
        foreach ($order as $key => $value) {
            $rawHash .= is_bool($value) ? ($value ? "true" : "false") : $value;
        }

        $order['signature'] = hash('sha256', $rawHash.$secretKey);

        return [
            'order' => $order
        ];
    }

    public function sendData($data)
    {
        $endpoint = $this->endPointProduction;
        if ($this->getTestMode())
            $endpoint = $this->endPointSandbox;

        $order = $data['order'];

        $body     = json_encode($order);
        $response = $this->httpClient->request('POST', $endpoint . '/payment/get-transaction', [], $body)->getBody();
        $result  = json_decode($response, true);

        return $this->response = new QueryResponse($this, $result);
    }

    protected function buildOrder()
    {
        return [
            'version' => $this->getVersion(),
            'merchantId' => $this->getMerchantId(),
            'terminalId' => $this->getTerminalId(),
            'orderId' => $this->getTransactionId()
        ];
    }
}