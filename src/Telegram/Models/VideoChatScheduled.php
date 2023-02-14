<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class VideoChatScheduled
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#videochatscheduled
 */
class VideoChatScheduled
{
    /**
     * Point in time (Unix timestamp) when the video chat is supposed to be started by a chat administrator
     */
    protected Carbon $start_date;

    public function __construct(array $payload)
    {
        $this->start_date = Carbon::createFromTimestamp(Arr::get($payload, 'start_date'));
    }

    public function getStartDate(): Carbon
    {
        return $this->start_date;
    }
}
