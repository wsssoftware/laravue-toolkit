<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#messageautodeletetimerchanged
 */
class MessageAutoDeleteTimerChanged
{

    /**
     * New auto-delete time for messages in the chat; in seconds
     *
     * @var int
     */
    protected int $message_auto_delete_time;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->message_auto_delete_time = (int) Arr::get($payload, 'message_auto_delete_time');
    }

    /**
     * @return int
     */
    public function getMessageAutoDeleteTime(): int
    {
        return $this->message_auto_delete_time;
    }

}
