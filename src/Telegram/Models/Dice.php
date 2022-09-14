<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#dice
 */
class Dice
{
    /**
     * Emoji on which the dice throw animation is based
     *
     * @var string
     */
    protected string $emoji;

    /**
     * Value of the dice, 1-6 for “🎲”, “🎯” and “🎳” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for “🎰”
     * base emoji
     *
     * @var int
     */
    protected int $value;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->emoji = Arr::get($payload, 'emoji');
        $this->value = (int) Arr::get($payload, 'value');
    }

    /**
     * @return string
     */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
