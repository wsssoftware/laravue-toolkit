<?php

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laravue\LaravueToolkit
 */
class LaravueToolkit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Laravue\LaravueToolkit::class;
    }
}
