<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#contact
 */
class Contact
{
    /**
     * Contact's phone number
     */
    protected string $phone_number;

    /**
     * Contact's first name
     */
    protected string $first_name;

    /**
     * Optional. Contact's last name
     */
    protected ?string $last_name;

    /**
     * Optional. Contact's user identifier in Telegram. This number may have more than 32 significant bits and some
     * programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant
     * bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    protected ?int $user_id;

    /**
     * Optional. Additional data about the contact in the form of a vCard
     */
    protected ?string $vcard;

    public function __construct(array $payload)
    {
        $this->phone_number = Arr::get($payload, 'phone_number');
        $this->first_name = Arr::get($payload, 'first_name');
        $this->last_name = Arr::get($payload, 'last_name');
        $this->user_id = ! empty(Arr::get($payload, 'user_id')) ? (int) Arr::get($payload, 'user_id') : null;
        $this->vcard = Arr::get($payload, 'vcard');
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getVcard(): ?string
    {
        return $this->vcard;
    }
}
