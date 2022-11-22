<?php

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isCrawler()
 *
 * @see \Laravue\Utility\Crawler\CrawlerDetector
 */
class CrawlerDetector extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\Crawler\CrawlerDetector::class;
    }
}
