<?php

namespace Laravue\Telegram\Enum;

/**
 * Class ChatType
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#poll
 */
enum PollType: string
{
    case REGULAR = 'regular';
    case QUIZ = 'quiz';
}
