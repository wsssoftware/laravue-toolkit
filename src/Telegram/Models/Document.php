<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Animation
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#document
 */
class Document extends BaseFile
{
    /**
     * Optional. Document thumbnail as defined by sender
     */
    protected ?PhotoSize $thumb;

    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->thumb = Arr::exists($payload, 'thumb') ? new PhotoSize($payload['thumb']) : null;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }
}
