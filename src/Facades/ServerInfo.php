<?php

namespace Laravue\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;

/**
 * @method static float cpuLoad()
 * @method static float cpuLoad5min()
 * @method static float cpuLoad15min()
 * @method static Carbon booted()
 * @method static float memoryUsage()
 * @method static float memoryTotal()
 * @method static float swapTotal()
 * @method static float swapUsage()
 * @method static float storageTotal()
 * @method static float storageUsage()
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
