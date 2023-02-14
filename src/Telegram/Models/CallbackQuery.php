<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class CallbackQuery
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#callbackquery
 */
class CallbackQuery
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
     * Optional. Message with the callback button that originated the query. Note that message content and message date
     * will not be available if the message is too old
     */
    protected ?Message $message;

    /**
     * Optional. Identifier of the message sent via the bot in inline mode, that originated the query.
     */
    protected ?string $inline_message_id;

    /**
     * Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent.
     * Useful for high scores in games.
     */
    protected ?string $chat_instance;

    /**
     * Optional. Data associated with the callback button. Be aware that the message originated the query can contain no
     * callback buttons with this data.
     */
    protected ?string $data;

    /**
     * Optional. Short name of a Game to be returned, serves as the unique identifier for the game
     */
    protected ?string $game_short_name;

    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->from = new User(Arr::get($payload, 'from'));
        $this->message = Arr::exists($payload, 'message') ? new Message(Arr::get($payload, 'message')) : null;
        $this->inline_message_id = Arr::get($payload, 'inline_message_id');
        $this->chat_instance = Arr::get($payload, 'chat_instance');
        $this->data = Arr::get($payload, 'data');
        $this->game_short_name = Arr::get($payload, 'game_short_name');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function getInlineMessageId(): ?string
    {
        return $this->inline_message_id;
    }

    public function getChatInstance(): ?string
    {
        return $this->chat_instance;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function getGameShortName(): ?string
    {
        return $this->game_short_name;
    }
}
