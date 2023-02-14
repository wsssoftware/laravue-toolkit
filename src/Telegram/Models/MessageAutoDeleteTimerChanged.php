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
     */
    protected int $message_auto_delete_time;

    public function __construct(array $payload)
    {
        $this->message_auto_delete_time = (int) Arr::get($payload, 'message_auto_delete_time');
    }

    public function getMessageAutoDeleteTime(): int
    {
        return $this->message_auto_delete_time;
    }
}
