<?php

namespace Laravue\Utility;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Linfo\OS\Darwin;
use Linfo\OS\Linux;
use Linfo\OS\Windows;

/**
 * Class ServerStatus
 *
 * Created by allancarvalho in setembro 14, 2022
 */
class ServerInfo
{

    /**
     * @var Darwin|Linux|Windows
     */
    protected Darwin|Linux|Windows $parser;

    /**
     *
     */
    public function __construct()
    {
        $linfo = new \Linfo\Linfo();
        $this->parser = $linfo->getParser();

    }

    /**
     * @return float
     */
    public function cpuLoad(): float
    {
        $loadNow = floatval(Arr::get($this->parser->getLoad(), 'now', 0));
        $coreCount = count($this->parser->getCPU());

        return round(($loadNow / $coreCount) * 100, 2);
    }

    /**
     * @return float
     */
    public function cpuLoad5min(): float
    {
        $loadNow = floatval(Arr::get($this->parser->getLoad(), '5min', 0));
        $coreCount = count($this->parser->getCPU());

        return round(($loadNow / $coreCount) * 100, 2);
    }

    /**
     * @return float
     */
    public function cpuLoad15min(): float
    {
        $loadNow = floatval(Arr::get($this->parser->getLoad(), '15min', 0));
        $coreCount = count($this->parser->getCPU());

        return round(($loadNow / $coreCount) * 100, 2);
    }

    /**
     * @return Carbon
     */
    public function booted(): Carbon
    {
        return Carbon::createFromTimestamp(intval(Arr::get($this->parser->getUpTime(), 'bootedTimestamp', 0)));
    }

    /**
     * @return float
     */
    public function memoryTotal(): float
    {
        return floatval(Arr::get($this->parser->getRam(), 'total', 0));
    }

    /**
     * @return float
     */
    public function memoryUsage(): float
    {
        return $this->memoryTotal() - floatval(Arr::get($this->parser->getRam(), 'free', 0));
    }

    /**
     * @return float
     */
    public function swapTotal(): float
    {
        return floatval(Arr::get($this->parser->getRam(), 'swapTotal', 0));
    }

    /**
     * @return float
     */
    public function swapUsage(): float
    {
        return $this->swapTotal() - floatval(Arr::get($this->parser->getRam(), 'swapFree', 0));
    }

    /**
     * @return float
     */
    public function storageTotal(): float
    {
        $total = 0;
        $counted = [];
        foreach ($this->parser->getMounts() as $mount) {
            $size = floatval(Arr::get($mount, 'size', 0));
            if (!in_array($size, $counted)) {
                $total += $size;
                $counted[] = $size;
            }
        }
        return $total;
    }

    /**
     * @return float
     */
    public function storageUsage(): float
    {
        $total = 0;
        $counted = [];
        foreach ($this->parser->getMounts() as $mount) {
            $size = floatval(Arr::get($mount, 'used', 0));
            if (!in_array($size, $counted)) {
                $total += $size;
                $counted[] = $size;
            }
        }
        return $total;
    }
}
