<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo
{
    /**
     * Optional. User name
     */
    protected string $name;

    /**
     * Optional. User's phone number
     */
    protected string $phone_number;

    /**
     * Optional. User email
     */
    protected string $email;

    /**
     * Optional. User shipping address
     */
    protected ShippingAddress $shipping_address;

    public function __construct(array $payload)
    {
        $this->name = Arr::get($payload, 'name');
        $this->phone_number = Arr::get($payload, 'phone_number');
        $this->email = Arr::get($payload, 'email');
        $this->shipping_address = Arr::exists($payload, 'shipping_address') ? new ShippingAddress(Arr::get($payload, 'shipping_address')) : null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shipping_address;
    }
}
