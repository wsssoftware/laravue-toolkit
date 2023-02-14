<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Chat
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link  https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions
{
    /**
     * Optional. True, if the user is allowed to send text messages, contacts, locations and venues
     */
    protected ?bool $can_send_messages;

    /**
     * Optional. True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes,
     * implies can_send_messages
     */
    protected ?bool $can_send_media_messages;

    /**
     * Optional. True, if the user is allowed to send polls, implies can_send_messages
     */
    protected ?bool $can_send_polls;

    /**
     * Optional. True, if the user is allowed to send animations, games, stickers and use inline bots, implies
     * can_send_media_messages
     */
    protected ?bool $can_send_other_messages;

    /**
     * Optional. True, if the user is allowed to add web page previews to their messages, implies
     * can_send_media_messages
     */
    protected ?bool $can_add_web_page_previews;

    /**
     * Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public
     * supergroups
     */
    protected ?bool $can_change_info;

    /**
     * Optional. True, if the user is allowed to invite new users to the chat
     */
    protected ?bool $can_invite_users;

    /**
     * Optional. True, if the user is allowed to pin messages. Ignored in public supergroups
     */
    protected ?bool $can_pin_messages;

    public function __construct(array $payload)
    {
        $this->can_send_messages = ! empty(Arr::exists($payload, 'can_send_messages')) ?
            boolval(Arr::get($payload, 'can_send_messages')) : null;
        $this->can_send_media_messages = ! empty(Arr::exists($payload, 'can_send_media_messages')) ?
            boolval(Arr::get($payload, 'can_send_media_messages')) : null;
        $this->can_send_polls = ! empty(Arr::exists($payload, 'can_send_polls')) ?
            boolval(Arr::get($payload, 'can_send_polls')) : null;
        $this->can_send_other_messages = ! empty(Arr::exists($payload, 'can_send_other_messages')) ?
            boolval(Arr::get($payload, 'can_send_other_messages')) : null;
        $this->can_add_web_page_previews = ! empty(Arr::exists($payload, 'can_add_web_page_previews')) ?
            boolval(Arr::get($payload, 'can_add_web_page_previews')) : null;
        $this->can_change_info = ! empty(Arr::exists($payload, 'can_change_info')) ?
            boolval(Arr::get($payload, 'can_change_info')) : null;
        $this->can_invite_users = ! empty(Arr::exists($payload, 'can_invite_users')) ?
            boolval(Arr::get($payload, 'can_invite_users')) : null;
        $this->can_pin_messages = ! empty(Arr::exists($payload, 'can_pin_messages')) ?
            boolval(Arr::get($payload, 'can_pin_messages')) : null;
    }

    public function getCanSendMessages(): ?bool
    {
        return $this->can_send_messages;
    }

    public function getCanSendMediaMessages(): ?bool
    {
        return $this->can_send_media_messages;
    }

    public function getCanSendPolls(): ?bool
    {
        return $this->can_send_polls;
    }

    public function getCanSendOtherMessages(): ?bool
    {
        return $this->can_send_other_messages;
    }

    public function getCanAddWebPagePreviews(): ?bool
    {
        return $this->can_add_web_page_previews;
    }

    public function getCanChangeInfo(): ?bool
    {
        return $this->can_change_info;
    }

    public function getCanInviteUsers(): ?bool
    {
        return $this->can_invite_users;
    }

    public function getCanPinMessages(): ?bool
    {
        return $this->can_pin_messages;
    }
}
