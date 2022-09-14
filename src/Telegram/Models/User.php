<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class User
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#user
 */
class User
{

    /**
     * Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming
     * languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a
     * 64-bit integer or double-precision float type are safe for storing this identifier.
     *
     * @var int
     */
    protected int $id;

    /**
     * True, if this user is a bot
     *
     * @var bool
     */
    protected bool $is_bot;

    /**
     * User's or bot's first name
     *
     * @var string
     */
    protected string $first_name;

    /**
     * Optional. User's or bot's last name
     *
     * @var string|null
     */
    protected ?string $last_name;

    /**
     * Optional. User's or bot's username
     *
     * @var string|null
     */
    protected ?string $username;

    /**
     * Optional. IETF language tag of the user's language
     *
     * @var string|null
     */
    protected ?string $language_code;

    /**
     * Optional. True, if this user is a Telegram Premium user
     *
     * @var bool|null
     */
    protected ?bool $is_premium;

    /**
     * Optional. True, if this user added the bot to the attachment menu
     *
     * @var bool|null
     */
    protected ?bool $added_to_attachment_menu;

    /**
     * Optional. True, if the bot can be invited to groups. Returned only in getMe.
     *
     * @var bool|null
     */
    protected ?bool $can_join_groups;

    /**
     * Optional. True, if privacy mode is disabled for the bot. Returned only in getMe.
     *
     * @var bool|null
     */
    protected ?bool $can_read_all_group_messages;

    /**
     * Optional. True, if the bot supports inline queries. Returned only in getMe.
     *
     * @var bool|null
     */
    protected ?bool $supports_inline_queries;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->id = intval(Arr::get($payload, 'id'));
        $this->is_bot = boolval(Arr::get($payload, 'is_bot'));
        $this->first_name = Arr::get($payload, 'first_name');
        $this->last_name = Arr::get($payload, 'last_name');
        $this->username = Arr::get($payload, 'username');
        $this->language_code = Arr::get($payload, 'language_code');
        $this->is_premium = !empty(Arr::exists($payload, 'is_premium')) ?
            boolval(Arr::get($payload, 'is_premium')) : null;
        $this->added_to_attachment_menu = !empty(Arr::exists($payload, 'added_to_attachment_menu')) ?
            boolval(Arr::get($payload, 'added_to_attachment_menu')) : null;
        $this->can_join_groups = !empty(Arr::exists($payload, 'can_join_groups')) ?
            boolval(Arr::get($payload, 'can_join_groups')) : null;
        $this->can_read_all_group_messages = !empty(Arr::exists($payload, 'can_read_all_group_messages')) ?
            boolval(Arr::get($payload, 'can_read_all_group_messages')) : null;
        $this->supports_inline_queries = !empty(Arr::exists($payload, 'supports_inline_queries')) ?
            boolval(Arr::get($payload, 'supports_inline_queries')) : null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isIsBot(): bool
    {
        return $this->is_bot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->language_code;
    }

    /**
     * @return bool|null
     */
    public function getIsPremium(): ?bool
    {
        return $this->is_premium;
    }

    /**
     * @return bool|null
     */
    public function getAddedToAttachmentMenu(): ?bool
    {
        return $this->added_to_attachment_menu;
    }

    /**
     * @return bool|null
     */
    public function getCanJoinGroups(): ?bool
    {
        return $this->can_join_groups;
    }

    /**
     * @return bool|null
     */
    public function getCanReadAllGroupMessages(): ?bool
    {
        return $this->can_read_all_group_messages;
    }

    /**
     * @return bool|null
     */
    public function getSupportsInlineQueries(): ?bool
    {
        return $this->supports_inline_queries;
    }
}
