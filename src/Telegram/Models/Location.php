<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Chat
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link  https://core.telegram.org/bots/api#location
 */
class Location
{

    /**
     * Longitude as defined by sender
     *
     * @var float
     */
    protected float $longitude;

    /**
     * Latitude as defined by sender
     *
     * @var float
     */
    protected float $latitude;

    /**
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     *
     * @var float|null
     */
    protected ?float $horizontal_accuracy;

    /**
     * Optional. Time relative to the message sending date, during which the location can be updated; in seconds. For
     * active live locations only.
     *
     * @var int|null
     */
    protected ?int $live_period;

    /**
     * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
     *
     * @var int|null
     */
    protected ?int $heading;

    /**
     * Optional. The maximum distance for proximity alerts about approaching another chat member, in meters. For sent
     * live locations only.
     *
     * @var int|null
     */
    protected ?int $proximity_alert_radius;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->longitude = Arr::get($payload, 'longitude', 0.0);
        $this->latitude = Arr::get($payload, 'latitude', 0.0);
        $this->horizontal_accuracy = !empty(Arr::exists($payload, 'horizontal_accuracy')) ?
            floatval(Arr::get($payload, 'horizontal_accuracy')) : null;
        $this->live_period = !empty(Arr::exists($payload, 'live_period')) ?
            intval(Arr::get($payload, 'live_period')) : null;
        $this->heading = !empty(Arr::exists($payload, 'heading')) ?
            intval(Arr::get($payload, 'headingsages')) : null;
        $this->proximity_alert_radius = !empty(Arr::exists($payload, 'proximity_alert_radius')) ?
            intval(Arr::get($payload, 'proximity_alert_radius')) : null;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float|null
     */
    public function getHorizontalAccuracy(): ?float
    {
        return $this->horizontal_accuracy;
    }

    /**
     * @return int|null
     */
    public function getLivePeriod(): ?int
    {
        return $this->live_period;
    }

    /**
     * @return int|null
     */
    public function getHeading(): ?int
    {
        return $this->heading;
    }

    /**
     * @return int|null
     */
    public function getProximityAlertRadius(): ?int
    {
        return $this->proximity_alert_radius;
    }
}
