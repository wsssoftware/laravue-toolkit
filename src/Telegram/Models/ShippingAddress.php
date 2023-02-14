<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#shippingaddress
 */
class ShippingAddress
{
    /**
     * Two-letter ISO 3166-1 alpha-2 country code
     */
    protected string $country_code;

    /**
     * State, if applicable
     */
    protected string $state;

    /**
     * City
     */
    protected string $city;

    /**
     * First line for the address
     */
    protected string $street_line1;

    /**
     * Second line for the address
     */
    protected string $street_line2;

    /**
     * Address post code
     */
    protected string $post_code;

    public function __construct(array $payload)
    {
        $this->country_code = Arr::get($payload, 'country_code');
        $this->state = Arr::get($payload, 'state');
        $this->city = Arr::get($payload, 'city');
        $this->street_line1 = Arr::get($payload, 'street_line1');
        $this->street_line2 = Arr::get($payload, 'street_line2');
        $this->post_code = Arr::get($payload, 'post_code');
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreetLine1(): string
    {
        return $this->street_line1;
    }

    public function getStreetLine2(): string
    {
        return $this->street_line2;
    }

    public function getPostCode(): string
    {
        return $this->post_code;
    }
}
