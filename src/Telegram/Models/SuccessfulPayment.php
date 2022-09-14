<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#successfulpayment
 */
class SuccessfulPayment
{
    /**
     * Three-letter ISO 4217 currency code
     *
     * @var string
     */
    protected string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of
     * US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the
     * decimal point for each currency (2 for the majority of currencies).
     *
     * @var int
     */
    protected int $total_amount;

    /**
     * Bot specified invoice payload
     *
     * @var string
     */
    protected string $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     *
     * @var string|null
     */
    protected ?string $shipping_option_id;

    /**
     * Optional. Order information provided by the user
     *
     * @var OrderInfo|null
     */
    protected ?OrderInfo $order_info;

    /**
     * Telegram payment identifier
     *
     * @var string
     */
    protected string $telegram_payment_charge_id;

    /**
     * Provider payment identifier
     *
     * @var string
     */
    protected string $provider_payment_charge_id;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->currency = Arr::get($payload, 'currency');
        $this->total_amount = (int) Arr::get($payload, 'total_amount');
        $this->invoice_payload = Arr::get($payload, 'invoice_payload');
        $this->shipping_option_id = Arr::get($payload, 'shipping_option_id');
        $this->order_info = Arr::exists($payload, 'order_info') ? new OrderInfo(Arr::get($payload, 'order_info')) : null;
        $this->telegram_payment_charge_id = Arr::get($payload, 'telegram_payment_charge_id');
        $this->provider_payment_charge_id = Arr::get($payload, 'provider_payment_charge_id');
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    /**
     * @return string
     */
    public function getInvoicePayload(): string
    {
        return $this->invoice_payload;
    }

    /**
     * @return string|null
     */
    public function getShippingOptionId(): ?string
    {
        return $this->shipping_option_id;
    }

    /**
     * @return OrderInfo|null
     */
    public function getOrderInfo(): ?OrderInfo
    {
        return $this->order_info;
    }

    /**
     * @return string
     */
    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegram_payment_charge_id;
    }

    /**
     * @return string
     */
    public function getProviderPaymentChargeId(): string
    {
        return $this->provider_payment_charge_id;
    }
}
