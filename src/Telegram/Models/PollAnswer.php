<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class PollAnswer
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer
{
    /**
     * Unique poll identifier
     */
    protected string $poll_id;

    /**
     * The user, who changed the answer to the poll
     */
    protected User $user;

    /**
     * 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
     *
     * @var int[]
     */
    protected array $option_ids;

    public function __construct(array $payload)
    {
        $this->poll_id = Arr::get($payload, 'poll_id');
        $this->user = new User(Arr::get($payload, 'user'));
        $this->option_ids = Arr::get($payload, 'option_ids');
    }

    public function getPollId(): string
    {
        return $this->poll_id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOptionIds(): array
    {
        return $this->option_ids;
    }
}
