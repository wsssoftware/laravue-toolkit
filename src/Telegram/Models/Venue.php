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
     *
     * @var Location
     */
    protected Location $location;

    /**
     * Name of the venue
     *
     * @var string
     */
    protected string $title;

    /**
     * Address of the venue
     *
     * @var string
     */
    protected string $address;

    /**
     * Optional. Foursquare identifier of the venue
     *
     * @var string|null
     */
    protected ?string $foursquare_id;

    /**
     * Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium”
     * or “food/icecream”.)
     *
     * @var string|null
     */
    protected ?string $foursquare_type;

    /**
     * Optional. Google Places identifier of the venue
     *
     * @var string|null
     */
    protected ?string $google_place_id;

    /**
     * Optional. Google Places type of the venue. (See supported types.)
     *
     * @var string|null
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getFoursquareId(): ?string
    {
        return $this->foursquare_id;
    }

    /**
     * @return string|null
     */
    public function getFoursquareType(): ?string
    {
        return $this->foursquare_type;
    }

    /**
     * @return string|null
     */
    public function getGooglePlaceId(): ?string
    {
        return $this->google_place_id;
    }

    /**
     * @return string|null
     */
    public function getGooglePlaceType(): ?string
    {
        return $this->google_place_type;
    }
}
