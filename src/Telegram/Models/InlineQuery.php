<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\ChatType;

/**
 * Class InlineQuery
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery
{
    /**
     * Unique identifier for this query
     */
    protected string $id;

    /**
     * Sender
     */
    protected User $from;

    /**
     * Text of the query (up to 256 characters)
     */
    protected string $query;

    /**
     * Offset of the results to be returned, can be controlled by the bot
     */
    protected string $offset;

    /**
     * Optional. Type of the chat from which the inline query was sent. Can be either “sender” for a private chat with
     * the inline query sender, “private”, “group”, “supergroup”, or “channel”. The chat type should be always known for
     * requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
     */
    protected ?ChatType $chat_type;

    /**
     * Optional. Sender location, only for bots that request user location
     */
    protected ?Location $location;

    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->from = new User(Arr::get($payload, 'from', []));
        $this->query = Arr::get($payload, 'query');
        $this->offset = Arr::get($payload, 'offset');
        $this->chat_type = Arr::exists($payload, 'chat_type') ? ChatType::from(Arr::get($payload, 'chat_type')) : null;
        $this->location = Arr::exists($payload, 'location') ? new Location(Arr::get($payload, 'location')) : null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getOffset(): string
    {
        return $this->offset;
    }

    public function getChatType(): ?ChatType
    {
        return $this->chat_type;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }
}
