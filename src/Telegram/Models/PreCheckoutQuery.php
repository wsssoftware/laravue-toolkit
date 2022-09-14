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
     *
     * @var string
     */
    protected string $id;

    /**
     * User who sent the query
     *
     * @var User
     */
    protected User $from;

    /**
     * Three-letter ISO 4217 currency code
     *
     * @var string
     */
    protected string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of
     * US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
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
     * @param  array  $payload
     */
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

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
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
}
