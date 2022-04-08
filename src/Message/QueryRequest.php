<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

use function GuzzleHttp\json_encode;
use function GuzzleHttp\json_decode;

class QueryRequest extends AbstractRequest
{
    public const TRANSACTION_URI = '/payment/get-transaction';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'version',
            'merchantId',
            'terminalId',
            'transactionId'
        );

        $order = [
            'version'    => $this->getVersion(),
            'merchantId' => $this->getMerchantId(),
            'terminalId' => $this->getTerminalId(),
            'orderId'    => $this->getTransactionId(),
        ];

        $order['signature'] = $this->computeSignature(
            implode('', array_values($order))
        );

        return [
            'order' => $order,
        ];
    }

    public function sendData($data): QueryResponse
    {
        $order = $this->buildOrder($data['order']);

        $payload  = json_encode($order);
        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint() . self::TRANSACTION_URI,
            [
                'Content-Type' => 'application/json',
            ],
            $payload
        )->getBody();

        $result = json_decode($response->getContents(), true);

        return $this->response = new QueryResponse($this, $result);
    }
}