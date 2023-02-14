<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#webappdata
 */
class WebAppData
{
    /**
     * The data. Be aware that a bad client can send arbitrary data in this field.
     */
    protected string $data;

    /**
     * Text of the web_app keyboard button from which the Web App was opened. Be aware that a bad client can send
     * arbitrary data in this field.
     */
    protected string $button_text;

    public function __construct(array $payload)
    {
        $this->data = Arr::get($payload, 'data');
        $this->button_text = Arr::get($payload, 'button_text');
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getButtonText(): string
    {
        return $this->button_text;
    }
}
