<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string temporaryFile(string $content)
 * @method static string mime(string $fileOrContent)
 *
 * @see \Laravue\Utility\File
 */
class File extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\File::class;
    }
}
