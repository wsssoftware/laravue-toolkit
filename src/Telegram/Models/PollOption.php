<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#polloption
 */
class PollOption
{

    /**
     * Option text, 1-100 characters
     *
     * @var string
     */
    protected string $text;

    /**
     * Number of users that voted for this option
     *
     * @var int
     */
    protected int $voter_count;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->text = Arr::get($payload, 'text');
        $this->voter_count = (int) Arr::get($payload, 'voter_count');
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getVoterCount(): int
    {
        return $this->voter_count;
    }
}
