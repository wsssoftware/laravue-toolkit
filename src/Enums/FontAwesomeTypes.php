<?php

namespace Laravue\Enums;

/**
 * Class FontAwesomeTypes
 *
 * Created by allancarvalho in fevereiro 02, 2023
 */
enum FontAwesomeTypes: string
{
    case SOLID = 'fa-solid';
    case REGULAR = 'fa-regular';
    case LIGHT = 'fa-light';
    case THIN = 'fa-thin';
    case DUOTONE = 'fa-duotone';

    public function getType(): string
    {
        return match ($this) {
            self::SOLID => 'fas',
            self::REGULAR => 'far',
            self::LIGHT => 'fal',
            self::THIN => 'fat',
            self::DUOTONE => 'fad',
        };
    }
}
