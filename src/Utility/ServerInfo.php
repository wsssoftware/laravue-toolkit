<?php

namespace Laravue\Utility;

/**
 * Class ServerStatus
 *
 * Created by allancarvalho in setembro 14, 2022
 */
class ServerInfo
{
    public function cpuLoad()
    {
        $load = sys_getloadavg();
        //$load = $load[0] / 2;

        return shell_exec('free');
    }
}
