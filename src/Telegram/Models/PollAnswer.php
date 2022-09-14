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
     *
     * @var string
     */
    protected string $poll_id;

    /**
     * The user, who changed the answer to the poll
     *
     * @var User
     */
    protected User $user;

    /**
     * 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
     *
     * @var int[]
     */
    protected array $option_ids;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->poll_id = Arr::get($payload, 'poll_id');
        $this->user = new User(Arr::get($payload, 'user'));
        $this->option_ids = Arr::get($payload, 'option_ids');
    }

    /**
     * @return string
     */
    public function getPollId(): string
    {
        return $this->poll_id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getOptionIds(): array
    {
        return $this->option_ids;
    }
}
