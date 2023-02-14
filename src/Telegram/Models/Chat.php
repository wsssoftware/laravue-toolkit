<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\ChatType;

/**
 * Class Chat
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link  https://core.telegram.org/bots/api#chat
 */
class Chat
{
    /**
     * Unique identifier for this chat. This number may have more than 32 significant bits and some programming
     * languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a
     * signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    protected int $id;

    /**
     * Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     */
    protected ChatType $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     */
    protected ?string $title;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     */
    protected ?string $username;

    /**
     * Optional. First name of the other party in a private chat
     */
    protected ?string $first_name;

    /**
     * Optional. Last name of the other party in a private chat
     */
    protected ?string $last_name;

    /**
     * Optional. Chat photo. Returned only in getChat.
     */
    protected ?ChatPhoto $photo;

    /**
     * Optional. Bio of the other party in a private chat. Returned only in getChat.
     */
    protected ?string $bio;

    /**
     * Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id>
     * links only in chats with the user. Returned only in getChat.
     */
    protected ?bool $has_private_forwards;

    /**
     * Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the
     * private chat. Returned only in getChat.
     */
    protected ?bool $has_restricted_voice_and_video_messages;

    /**
     * Optional. True, if users need to join the supergroup before they can send messages. Returned only in getChat.
     */
    protected ?bool $join_to_send_messages;

    /**
     * Optional. True, if all users directly joining the supergroup need to be approved by supergroup administrators.
     * Returned only in getChat.
     */
    protected ?bool $join_by_request;

    /**
     * Optional. Description, for groups, supergroups and channel chats. Returned only in getChat.
     */
    protected ?string $description;

    /**
     * Optional. Primary invite link, for groups, supergroups and channel chats. Returned only in getChat.
     */
    protected ?string $invite_link;

    /**
     * Optional. The most recent pinned message (by sending date). Returned only in getChat.
     */
    protected ?Message $pinned_message;

    /**
     * Optional. Default chat member permissions, for groups and supergroups. Returned only in getChat.
     */
    protected ?ChatPermissions $permissions;

    /**
     * Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged
     * user; in seconds. Returned only in getChat.
     */
    protected ?int $slow_mode_delay;

    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds. Returned
     * only in getChat.
     */
    protected ?int $message_auto_delete_time;

    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
     */
    protected ?bool $has_protected_content;

    /**
     * Optional. For supergroups, name of group sticker set. Returned only in getChat.
     */
    protected ?string $sticker_set_name;

    /**
     * Optional. True, if the bot can change the group sticker set. Returned only in getChat.
     */
    protected ?bool $can_set_sticker_set;

    /**
     * Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice
     * versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64
     * bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat.
     */
    protected ?int $linked_chat_id;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected. Returned only in getChat.
     */
    protected ?ChatLocation $location;

    public function __construct(array $payload)
    {
        $this->id = intval(Arr::get($payload, 'id'));
        $this->type = ChatType::from(Arr::get($payload, 'type'));
        $this->title = Arr::get($payload, 'title');
        $this->username = Arr::get($payload, 'username');
        $this->first_name = Arr::get($payload, 'first_name');
        $this->last_name = Arr::get($payload, 'last_name');
        $this->photo = Arr::exists($payload, 'photo') ? new ChatPhoto(Arr::get($payload, 'photo', [])) : null;
        $this->bio = Arr::get($payload, 'bio');
        $this->has_private_forwards = ! empty(Arr::exists($payload, 'has_private_forwards')) ?
            boolval(Arr::get($payload, 'has_private_forwards')) : null;
        $this->has_restricted_voice_and_video_messages = ! empty(Arr::exists($payload, 'has_restricted_voice_and_video_messages')) ?
            boolval(Arr::get($payload, 'has_restricted_voice_and_video_messages')) : null;
        $this->join_to_send_messages = ! empty(Arr::exists($payload, 'join_to_send_messages')) ?
            boolval(Arr::get($payload, 'join_to_send_messages')) : null;
        $this->join_by_request = ! empty(Arr::exists($payload, 'join_by_request')) ?
            boolval(Arr::get($payload, 'join_by_request')) : null;
        $this->description = Arr::get($payload, 'description');
        $this->bio = Arr::get($payload, 'bio');
        $this->invite_link = Arr::get($payload, 'invite_link');
        $this->pinned_message = Arr::exists($payload, 'pinned_message') ? new Message(Arr::get($payload, 'pinned_message', [])) : null;
        $this->permissions = Arr::exists($payload, 'permissions') ? new ChatPermissions(Arr::get($payload, 'permissions', [])) : null;
        $this->slow_mode_delay = ! empty(Arr::exists($payload, 'slow_mode_delay')) ?
            intval(Arr::get($payload, 'slow_mode_delay')) : null;
        $this->message_auto_delete_time = ! empty(Arr::exists($payload, 'message_auto_delete_time')) ?
            intval(Arr::get($payload, 'message_auto_delete_time')) : null;
        $this->has_protected_content = ! empty(Arr::exists($payload, 'has_protected_content')) ?
            boolval(Arr::get($payload, 'has_protected_content')) : null;
        $this->sticker_set_name = Arr::get($payload, 'sticker_set_name');
        $this->can_set_sticker_set = ! empty(Arr::exists($payload, 'can_set_sticker_set')) ?
            boolval(Arr::get($payload, 'can_set_sticker_set')) : null;
        $this->linked_chat_id = ! empty(Arr::exists($payload, 'linked_chat_id')) ?
            intval(Arr::get($payload, 'linked_chat_id')) : null;
        $this->location = Arr::exists($payload, 'location') ? new ChatLocation(Arr::get($payload, 'location', [])) : null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): ChatType
    {
        return $this->type;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getPhoto(): ?ChatPhoto
    {
        return $this->photo;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getHasPrivateForwards(): ?bool
    {
        return $this->has_private_forwards;
    }

    public function getHasRestrictedVoiceAndVideoMessages(): ?bool
    {
        return $this->has_restricted_voice_and_video_messages;
    }

    public function getJoinToSendMessages(): ?bool
    {
        return $this->join_to_send_messages;
    }

    public function getJoinByRequest(): ?bool
    {
        return $this->join_by_request;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getInviteLink(): ?string
    {
        return $this->invite_link;
    }

    public function getPinnedMessage(): ?Message
    {
        return $this->pinned_message;
    }

    public function getPermissions(): ?ChatPermissions
    {
        return $this->permissions;
    }

    public function getSlowModeDelay(): ?int
    {
        return $this->slow_mode_delay;
    }

    public function getMessageAutoDeleteTime(): ?int
    {
        return $this->message_auto_delete_time;
    }

    public function getHasProtectedContent(): ?bool
    {
        return $this->has_protected_content;
    }

    public function getStickerSetName(): ?string
    {
        return $this->sticker_set_name;
    }

    public function getCanSetStickerSet(): ?bool
    {
        return $this->can_set_sticker_set;
    }

    public function getLinkedChatId(): ?int
    {
        return $this->linked_chat_id;
    }

    public function getLocation(): ?ChatLocation
    {
        return $this->location;
    }
}
