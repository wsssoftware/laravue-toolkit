<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#venue
 */
class Venue
{
    /**
     * Venue location. Can't be a live location
     */
    protected Location $location;

    /**
     * Name of the venue
     */
    protected string $title;

    /**
     * Address of the venue
     */
    protected string $address;

    /**
     * Optional. Foursquare identifier of the venue
     */
    protected ?string $foursquare_id;

    /**
     * Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium”
     * or “food/icecream”.)
     */
    protected ?string $foursquare_type;

    /**
     * Optional. Google Places identifier of the venue
     */
    protected ?string $google_place_id;

    /**
     * Optional. Google Places type of the venue. (See supported types.)
     */
    protected ?string $google_place_type;

    public function __construct(array $payload)
    {
        $this->location = new Location(Arr::get($payload, 'location'));
        $this->title = Arr::get($payload, 'title');
        $this->address = Arr::get($payload, 'address');
        $this->foursquare_id = Arr::get($payload, 'foursquare_id');
        $this->foursquare_type = Arr::get($payload, 'foursquare_type');
        $this->google_place_id = Arr::get($payload, 'google_place_id');
        $this->google_place_type = Arr::get($payload, 'google_place_type');
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getFoursquareId(): ?string
    {
        return $this->foursquare_id;
    }

    public function getFoursquareType(): ?string
    {
        return $this->foursquare_type;
    }

    public function getGooglePlaceId(): ?string
    {
        return $this->google_place_id;
    }

    public function getGooglePlaceType(): ?string
    {
        return $this->google_place_type;
    }
}
