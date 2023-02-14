<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo
{
    /**
     * An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
     */
    protected string $url;

    public function __construct(array $payload)
    {
        $this->url = Arr::get($payload, 'url');
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
