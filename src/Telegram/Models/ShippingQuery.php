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
     */
    protected string $id;

    /**
     * User who sent the query
     */
    protected User $from;

    /**
     * Bot specified invoice payload
     */
    protected string $invoice_payload;

    /**
     * User specified shipping address
     */
    protected ShippingAddress $shipping_address;

    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->from = new User(Arr::get($payload, 'from'));
        $this->invoice_payload = Arr::get($payload, 'invoice_payload');
        $this->shipping_address = new ShippingAddress(Arr::get($payload, 'shipping_address'));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getInvoicePayload(): string
    {
        return $this->invoice_payload;
    }

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shipping_address;
    }
}
