<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array pluck(string|array $enum, bool $sort = true)
 * @method static array toArray(string|array $enum)
 *
 * @see \Laravue\Utility\Enum
 */
class Enum extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\Enum::class;
    }
}
