<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class ProximityAlertTriggered
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered
{

    /**
     * User that triggered the alert
     *
     * @var User
     */
    protected User $traveler;

    /**
     * User that set the alert
     *
     * @var User
     */
    protected User $watcher;

    /**
     * The distance between the users
     *
     * @var int
     */
    protected int $distance;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->traveler = new User(Arr::get($payload, 'traveler'));
        $this->watcher = new User(Arr::get($payload, 'watcher'));
        $this->distance = (int) Arr::get($payload, 'distance');
    }

    /**
     * @return User
     */
    public function getTraveler(): User
    {
        return $this->traveler;
    }

    /**
     * @return User
     */
    public function getWatcher(): User
    {
        return $this->watcher;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

}
