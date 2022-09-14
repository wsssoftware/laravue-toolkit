<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#voice
 */
class Voice extends BaseFile
{
    /**
     * Duration of the audio in seconds as defined by sender
     *
     * @var int
     */
    protected int $duration;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->duration = Arr::get($payload, 'duration');
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }
}
