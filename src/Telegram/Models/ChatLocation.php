<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Chat
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link  https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation
{

    /**
     * The location to which the supergroup is connected. Can't be a live location.
     *
     * @var Location
     */
    protected Location $location;

    /**
     * Location address; 1-64 characters, as defined by the chat owner
     *
     * @var string
     */
    protected string $address;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->location = new Location(Arr::get($payload, 'location'));
        $this->address = Arr::get($payload, 'address');
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}
