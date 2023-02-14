<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Animation
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#animation
 */
class Animation extends BaseFile
{
    /**
     * 	Video width as defined by sender
     */
    protected int $width;

    /**
     * 	Video height as defined by sender
     */
    protected int $height;

    /**
     * 	Duration of the video in seconds as defined by sender
     */
    protected int $duration;

    /**
     * 	Optional. Animation thumbnail as defined by sender
     */
    protected ?PhotoSize $thumb;

    public function __construct(array $payload)
    {
        parent::__construct($payload);

        $this->width = intval(Arr::get($payload, 'width', 0));
        $this->height = intval(Arr::get($payload, 'height', 0));
        $this->duration = intval(Arr::get($payload, 'duration', 0));
        $this->thumb = Arr::exists($payload, 'thumb') ? new PhotoSize(Arr::get($payload, 'thumb')) : null;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }
}
