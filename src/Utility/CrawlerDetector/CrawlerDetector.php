<?php

namespace Laravue\Utility\CrawlerDetector;

use Illuminate\Http\Request;

/**
 * Class CrawlerDetector
 *
 * Created by allancarvalho in novembro 22, 2022
 */
class CrawlerDetector
{
    use CrawlerList;
    use ExclusionList;

    /**
     * All possible HTTP headers that represent the user agent string.
     *
     * @var array
     */
    protected array $headerNames = [
        'HTTP_USER_AGENT',
        'HTTP_X_OPERAMINI_PHONE_UA',
        'HTTP_X_DEVICE_USER_AGENT',
        'HTTP_X_ORIGINAL_USER_AGENT',
        'HTTP_X_SKYFIRE_PHONE',
        'HTTP_X_BOLT_PHONE_UA',
        'HTTP_DEVICE_STOCK_UA',
        'HTTP_X_UCBROWSER_DEVICE_UA',
        'HTTP_FROM',
        'HTTP_X_SCANNER'
    ];

    /**
     * Store regex matches.
     *
     * @var array
     */
    protected array $matches = [];

    /**
     * @var string
     */
    protected string $userAgent;

    /**
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    /**
     * Class constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setUserAgent();
    }

    /**
     * @return void
     */
    protected function setUserAgent(): void
    {
        $headers = [];
        foreach ($this->request->server() as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headers[$key] = $value;
            }
        }
        $userAgent = '';
        foreach ($this->headerNames as $altHeader) {
            if (isset($headers[$altHeader])) {
                $userAgent .= $headers[$altHeader].' ';
            }
        }
        $this->userAgent = trim($userAgent);
    }

    /**
     * Check user agent string against the regex.
     *
     * @return bool
     */
    public function isCrawler(): bool
    {
        $agent = trim(preg_replace($this->getExclusionRegex(), '', $this->userAgent));
        if ($agent === '') {
            return false;
        }
        return (bool) preg_match($this->getCrawlerRegex(), $agent, $this->matches);
    }

    /**
     * Return the matches.
     *
     * @return string|null
     */
    public function getMatches(): ?string
    {
        return $this->matches[0] ?? null;
    }
}
