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
     */
    protected User $traveler;

    /**
     * User that set the alert
     */
    protected User $watcher;

    /**
     * The distance between the users
     */
    protected int $distance;

    public function __construct(array $payload)
    {
        $this->traveler = new User(Arr::get($payload, 'traveler'));
        $this->watcher = new User(Arr::get($payload, 'watcher'));
        $this->distance = (int) Arr::get($payload, 'distance');
    }

    public function getTraveler(): User
    {
        return $this->traveler;
    }

    public function getWatcher(): User
    {
        return $this->watcher;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }
}
