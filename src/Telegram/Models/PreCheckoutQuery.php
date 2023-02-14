<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class PreCheckoutQuery
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#precheckoutquery
 */
class PreCheckoutQuery
{
    /**
     * Unique query identifier
     */
    protected string $id;

    /**
     * User who sent the query
     */
    protected User $from;

    /**
     * Three-letter ISO 4217 currency code
     */
    protected string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of
     * US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     */
    protected int $total_amount;

    /**
     * Bot specified invoice payload
     */
    protected string $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     */
    protected ?string $shipping_option_id;

    /**
     * Optional. Order information provided by the user
     */
    protected ?OrderInfo $order_info;

    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->from = new User(Arr::get($payload, 'from'));
        $this->currency = Arr::get($payload, 'currency');
        $this->total_amount = (int) Arr::get($payload, 'total_amount');
        $this->invoice_payload = Arr::get($payload, 'invoice_payload');
        $this->shipping_option_id = Arr::get($payload, 'shipping_option_id');
        $this->order_info = Arr::exists($payload, 'order_info') ? new OrderInfo(Arr::get($payload, 'order_info')) : null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    public function getInvoicePayload(): string
    {
        return $this->invoice_payload;
    }

    public function getShippingOptionId(): ?string
    {
        return $this->shipping_option_id;
    }

    public function getOrderInfo(): ?OrderInfo
    {
        return $this->order_info;
    }
}
