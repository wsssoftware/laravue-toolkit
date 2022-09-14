<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class VideoChatParticipantsInvited
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#videochatparticipantsinvited
 */
class VideoChatParticipantsInvited
{
    /**
     * New members that were invited to the video chat
     *
     * @var array
     */
    protected array $users = [];

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        foreach (Arr::get($payload, 'users') as $user) {
            $this->users[] = new User($user);
        }
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}
