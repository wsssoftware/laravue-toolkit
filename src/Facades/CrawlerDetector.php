<?php

namespace Laravue\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isCrawler(string $userAgent = null)
 * @method static string|null getMatches()
 *
 * @see \Jaybizzle\CrawlerDetect\CrawlerDetect
 */
class CrawlerDetector extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laravue\Utility\CrawlerDetector\CrawlerDetector::class;
    }
}
