<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\MessageEntityType;

/**
 * Class MessageEntity
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity
{

    /**
     * Type of the entity. Currently, can be “mention” (@username), “hashtag” (#hashtag), “cashtag” ($USD),
     * “bot_command” (/start@jobs_bot), “url” (https://telegram.org), “email” (do-not-reply@telegram.org),
     * “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text),
     * “strikethrough” (strikethrough text), “spoiler” (spoiler message), “code” (monowidth string), “pre”
     * (monowidth block), “text_link” (for clickable text URLs), “text_mention” (for users without usernames),
     * “custom_emoji” (for inline custom emoji stickers)
     *
     * @var MessageEntityType
     */
    protected MessageEntityType $type;

    /**
     * Offset in UTF-16 code units to the start of the entity
     *
     * @var int
     */
    protected int $offset;

    /**
     * Length of the entity in UTF-16 code units
     *
     * @var int
     */
    protected int $length;

    /**
     * Optional. For “text_link” only, URL that will be opened after user taps on the text
     *
     * @var string|null
     */
    protected ?string $url;

    /**
     * Optional. For “text_mention” only, the mentioned user
     *
     * @var User|null
     */
    protected ?User $user;

    /**
     * Optional. For “pre” only, the programming language of the entity text
     *
     * @var string|null
     */
    protected ?string $language;

    /**
     * Optional. For “custom_emoji” only, unique identifier of the custom emoji. Use getCustomEmojiStickers to get full
     * information about the sticker
     *
     * @var string|null
     */
    protected ?string $custom_emoji_id;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->type = MessageEntityType::from(Arr::get($payload, 'type'));
        $this->offset = (int) Arr::get($payload, 'offset');
        $this->length = (int) Arr::get($payload, 'length');
        $this->url = Arr::get($payload, 'url');
        $this->user = Arr::exists($payload, 'user') ? new User(Arr::get($payload, 'user')) : null;
        $this->language = Arr::get($payload, 'language');
        $this->custom_emoji_id = Arr::get($payload, 'custom_emoji_id');
    }

    /**
     * @return MessageEntityType
     */
    public function getType(): MessageEntityType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @return string|null
     */
    public function getCustomEmojiId(): ?string
    {
        return $this->custom_emoji_id;
    }
}
