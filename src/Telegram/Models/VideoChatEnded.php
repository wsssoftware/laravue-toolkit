<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class VideoChatEnded
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#videochatended
 */
class VideoChatEnded
{
    /**
     * Video chat duration in seconds
     */
    protected int $duration;

    public function __construct(array $payload)
    {
        $this->duration = Arr::get($payload, 'duration');
    }
}
