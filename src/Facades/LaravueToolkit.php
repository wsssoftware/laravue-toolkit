<?php

namespace Laravue\LaravueToolkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laravue\LaravueToolkit\LaravueToolkit
 */
class LaravueToolkit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Laravue\LaravueToolkit\LaravueToolkit::class;
    }
}
