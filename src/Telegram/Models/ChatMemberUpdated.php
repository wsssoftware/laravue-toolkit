<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class ChatMemberUpdated
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated
{
    /**
     * Chat the user belongs to
     *
     * @var Chat
     */
    protected Chat $chat;

    /**
     * Performer of the action, which resulted in the change
     *
     * @var User
     */
    protected User $from;

    /**
     * Date the change was done in Unix time
     *
     * @var Carbon
     */
    protected Carbon $date;

    /**
     * Previous information about the chat member
     *
     * @var array
     */
    protected array $old_chat_member;

    /**
     * New information about the chat member
     *
     * @var array
     */
    protected array $new_chat_member;

    /**
     * Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
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
        $this->old_chat_member = Arr::get($payload, 'old_chat_member');
        $this->new_chat_member = Arr::get($payload, 'new_chat_member');
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
     * @return array
     */
    public function getOldChatMember(): array
    {
        return $this->old_chat_member;
    }

    /**
     * @return array
     */
    public function getNewChatMember(): array
    {
        return $this->new_chat_member;
    }

    /**
     * @return ChatInviteLink|null
     */
    public function getInviteLink(): ?ChatInviteLink
    {
        return $this->invite_link;
    }
}
