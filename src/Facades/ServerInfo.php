<?php

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string cpuLoad()
 *
 * @see \Laravue\Utility\ServerInfo
 */
class ServerInfo extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return 'utility.server_info';
    }
}
