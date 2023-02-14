<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class ChatJoinRequest
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest
{
    /**
     * Chat to which the request was sent
     */
    protected Chat $chat;

    /**
     * User that sent the join request
     */
    protected User $from;

    /**
     * Date the request was sent in Unix time
     */
    protected Carbon $date;

    /**
     * Optional. Bio of the user.
     */
    protected ?string $bio;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     */
    protected ?ChatInviteLink $invite_link;

    public function __construct(array $payload)
    {
        $this->chat = new Chat(Arr::get($payload, 'chat'));
        $this->from = new User(Arr::get($payload, 'from'));
        $this->date = Carbon::createFromTimestamp(Arr::get($payload, 'date'));
        $this->bio = Arr::get($payload, 'bio');
        $this->invite_link = Arr::exists($payload, 'invite_link') ? new ChatInviteLink(Arr::get($payload, 'invite_link')) : null;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getInviteLink(): ?ChatInviteLink
    {
        return $this->invite_link;
    }
}
