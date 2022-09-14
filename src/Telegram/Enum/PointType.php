<?php

namespace Laravue\Telegram\Enum;

/**
 * Class ChatType
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#maskposition
 */
enum PointType: string
{
    case FOREHEAD = 'forehead';
    case EYES = 'eyes';
    case MOUTH = 'mouth';
    case CHIN = 'chin';
}
