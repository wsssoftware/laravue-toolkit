<?php

namespace Laravue\Utility\Crawler;

use Illuminate\Http\Request;
use Laravue\Utility\Crawler\Fixtures\Crawlers;
use Laravue\Utility\Crawler\Fixtures\Exclusions;

/**
 * Class CrawlerDetector
 *
 * Created by allancarvalho in novembro 22, 2022
 */
class CrawlerDetector
{
    protected Request $request;

    /**
     * The compiled regex string.
     *
     * @var string
     */
    protected string $compiledRegex;

    /**
     * The compiled exclusions regex string.
     *
     * @var string
     */
    protected string $compiledExclusionsRegex;

    /**
     * @param  Request  $request  ]
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->compiledRegex = $this->compileRegex(Crawlers::getAll());
        $this->compiledExclusionsRegex = $this->compileRegex(Exclusions::getAll());
    }

    /**
     * Compile the regex patterns into one regex string.
     *
     * @param array  $patterns
     *
     * @return string
     */
    public function compileRegex(array $patterns): string
    {
        return '('.implode('|', $patterns).')';
    }

    /**
     * @return bool
     */
    public function isCrawler(): bool
    {
        $agent = trim(preg_replace(
            "/{$this->compiledExclusionsRegex}/i",
            '',
            $this->request->userAgent()
        ));

        if ($agent === '') {
            return false;
        }

        $matches = [];
        return (bool) preg_match("/{$this->compiledRegex}/i", $agent, $matches);
    }
}
