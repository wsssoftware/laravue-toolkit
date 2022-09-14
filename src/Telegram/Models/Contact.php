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
     *
     * @var string
     */
    protected string $phone_number;

    /**
     * Contact's first name
     *
     * @var string
     */
    protected string $first_name;

    /**
     * Optional. Contact's last name
     *
     * @var string|null
     */
    protected ?string $last_name;

    /**
     * Optional. Contact's user identifier in Telegram. This number may have more than 32 significant bits and some
     * programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant
     * bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     *
     * @var int|null
     */
    protected ?int $user_id;

    /**
     * Optional. Additional data about the contact in the form of a vCard
     *
     * @var string|null
     */
    protected ?string $vcard;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->phone_number = Arr::get($payload, 'phone_number');
        $this->first_name = Arr::get($payload, 'first_name');
        $this->last_name = Arr::get($payload, 'last_name');
        $this->user_id = !empty(Arr::get($payload, 'user_id')) ? (int) Arr::get($payload, 'user_id') : null;
        $this->vcard = Arr::get($payload, 'vcard');
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
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @return string|null
     */
    public function getVcard(): ?string
    {
        return $this->vcard;
    }

}
