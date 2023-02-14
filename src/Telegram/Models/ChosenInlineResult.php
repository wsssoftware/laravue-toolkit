<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class ChosenInlineResult
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult
{
    /**
     * The unique identifier for the result that was chosen
     */
    protected string $result_id;

    /**
     * The user that chose the result
     */
    protected User $from;

    /**
     * Optional. Sender location, only for bots that require user location
     */
    protected ?Location $location;

    /**
     * Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the
     * message. Will be also received in callback queries and can be used to edit the message.
     */
    protected ?string $inline_message_id;

    /**
     * The query that was used to obtain the result
     */
    protected string $query;

    public function __construct(array $payload)
    {
        $this->result_id = Arr::get($payload, 'result_id');
        $this->from = new User(Arr::get($payload, 'from'));
        $this->location = Arr::exists($payload, 'location') ? new Location(Arr::get($payload, 'location')) : null;
        $this->inline_message_id = Arr::get($payload, 'inline_message_id');
        $this->query = Arr::get($payload, 'query');
    }

    public function getResultId(): string
    {
        return $this->result_id;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getInlineMessageId(): ?string
    {
        return $this->inline_message_id;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
