<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string toList(array $list, array $options = [])
 *
 * @see \Laravue\Utility\Text
 */
class Text extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\Text::class;
    }
}
