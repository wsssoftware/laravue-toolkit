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
     *
     * @var string
     */
    protected string $name;

    /**
     * Optional. User's phone number
     *
     * @var string
     */
    protected string $phone_number;

    /**
     * Optional. User email
     *
     * @var string
     */
    protected string $email;

    /**
     * Optional. User shipping address
     *
     * @var ShippingAddress
     */
    protected ShippingAddress $shipping_address;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->name = Arr::get($payload, 'name');
        $this->phone_number = Arr::get($payload, 'phone_number');
        $this->email = Arr::get($payload, 'email');
        $this->shipping_address = Arr::exists($payload, 'shipping_address') ? new ShippingAddress(Arr::get($payload, 'shipping_address')) : null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shipping_address;
    }
}
