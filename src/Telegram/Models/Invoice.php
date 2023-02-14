<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#invoice
 */
class Invoice
{
    /**
     * Product name
     */
    protected string $title;

    /**
     * Product description
     */
    protected string $description;

    /**
     * Unique bot deep-linking parameter that can be used to generate this invoice
     */
    protected string $start_parameter;

    /**
     * Three-letter ISO 4217 currency code
     */
    protected string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of
     * US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the
     * decimal point for each currency (2 for the majority of currencies).
     */
    protected int $total_amount;

    public function __construct(array $payload)
    {
        $this->title = Arr::get($payload, 'title');
        $this->description = Arr::get($payload, 'description');
        $this->start_parameter = Arr::get($payload, 'start_parameter');
        $this->currency = Arr::get($payload, 'currency');
        $this->total_amount = (int) Arr::get($payload, 'total_amount');
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartParameter(): string
    {
        return $this->start_parameter;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }
}
