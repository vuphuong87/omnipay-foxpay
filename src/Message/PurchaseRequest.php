<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

use function Symfony\Component\String\s;

class PurchaseRequest extends AbstractRequest
{
    public const CHECKOUT_URI = '/payment/checkout';

    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'version',
            'merchantId',
            'terminalId',
            'transactionId',
            'amount',
            'description',
        );

        $order = [
            'version'     => $this->getVersion(),
            'merchantId'  => $this->getMerchantId(),
            'terminalId'  => $this->getTerminalId(),
            'orderId'     => $this->getTransactionId(),
            'amount'      => $this->getAmount(),
            'currency'    => $this->getCurrency(),
            'returnToken' => $this->getReturnToken() ? 'true' : 'false',
            'returnUrl'   => $this->getReturnUrl(),
        ];

        $order['signature'] = $this->calculateSignature(
            implode('', array_values($order))
        );

        return [
            'order' => $order,
        ];
    }

    public function sendData($data): PurchaseResponse
    {
        $order = $this->buildOrder($data['order']);

        $result['redirectUrl'] = $this->getEndpoint() . self::CHECKOUT_URI . '?' . urldecode(http_build_query($order));

        return $this->response = new PurchaseResponse($this, $result);
    }
}