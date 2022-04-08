<?php

declare(strict_types=1);

namespace Omnipay\Foxpay\Message;

use DateTime;
use DateTimeZone;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    public const CHECKOUT_URI = '/payment/checkout';

    public const TIMEZONE = 'Asia/Ho_Chi_Minh';

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

        $validityTime = $this->getValidityTime() ?: new DateTime('+24 hours');
        $validityTime->setTimezone(new DateTimeZone(self::TIMEZONE));
        $validityTime = $validityTime->format('dmY His');

        $order = [
            'version'     => $this->getVersion(),
            'merchantId'  => $this->getMerchantId(),
            'terminalId'  => $this->getTerminalId(),
            'orderId'     => $this->getTransactionId(),
            'amount'      => $this->getAmount(),
            'currency'    => $this->getCurrency(),
            // does not support for Checkout API but QR API for now
            //'expiredTime' => $validityTime,
            'returnToken' => $this->getReturnToken() ? 'true' : 'false',
            'returnUrl'   => $this->getReturnUrl(),
        ];

        $order['signature'] = $this->computeSignature(
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