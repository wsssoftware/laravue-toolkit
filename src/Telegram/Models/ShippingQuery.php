<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class ShippingQuery
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#shippingquery
 */
class ShippingQuery
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
     * Bot specified invoice payload
     *
     * @var string
     */
    protected string $invoice_payload;

    /**
     * User specified shipping address
     *
     * @var ShippingAddress
     */
    protected ShippingAddress $shipping_address;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->from = new User(Arr::get($payload, 'from'));
        $this->invoice_payload = Arr::get($payload, 'invoice_payload');
        $this->shipping_address = new ShippingAddress(Arr::get($payload, 'shipping_address'));
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
    public function getInvoicePayload(): string
    {
        return $this->invoice_payload;
    }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shipping_address;
    }
}
