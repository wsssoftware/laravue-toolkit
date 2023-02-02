<?php

namespace Laravue\Enums;

/**
 * Class FlashPositions
 *
 * Created by allancarvalho in fevereiro 02, 2023
 */
enum FlashPositions: string
{
    case TOP_RIGHT = 'top-right';
    case TOP = 'top-center';
    case TOP_LEFT = 'top-left';
    case BOTTOM_RIGHT = 'bottom-right';
    case BOTTOM = 'bottom-center';
    case BOTTOM_LEFT = 'bottom-left';
}
