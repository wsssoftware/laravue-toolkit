<?php

namespace Laravue\Utility;

use Exception;
use const PHP_OS_FAMILY;

/**
 * Class ServerStatus
 *
 * Created by allancarvalho in setembro 14, 2022
 */
class ServerStatus
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            throw new Exception('This Facade is not supported on Windows.');
        }
    }

    public function cpuLoad()
    {
        $load = sys_getloadavg();
        //$load = $load[0] / 2;

        return shell_exec('free');
    }
}
