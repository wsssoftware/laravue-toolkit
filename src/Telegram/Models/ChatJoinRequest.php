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
     *
     * @var Chat
     */
    protected Chat $chat;

    /**
     * User that sent the join request
     *
     * @var User
     */
    protected User $from;

    /**
     * Date the request was sent in Unix time
     *
     * @var Carbon
     */
    protected Carbon $date;

    /**
     * Optional. Bio of the user.
     *
     * @var string|null
     */
    protected ?string $bio;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     *
     * @var ChatInviteLink|null
     */
    protected ?ChatInviteLink $invite_link;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->chat = new Chat(Arr::get($payload, 'chat'));
        $this->from = new User(Arr::get($payload, 'from'));
        $this->date = Carbon::createFromTimestamp(Arr::get($payload, 'date'));
        $this->bio = Arr::get($payload, 'bio');
        $this->invite_link = Arr::exists($payload, 'invite_link') ? new ChatInviteLink(Arr::get($payload, 'invite_link')) : null;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @return ChatInviteLink|null
     */
    public function getInviteLink(): ?ChatInviteLink
    {
        return $this->invite_link;
    }
}
