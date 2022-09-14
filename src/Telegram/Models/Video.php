<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#video
 */
class Video extends BaseFile
{
    /**
     * Video width as defined by sender
     *
     * @var int
     */
    protected int $width;

    /**
     * Video height as defined by sender
     *
     * @var int
     */
    protected int $height;

    /**
     * Duration of the video in seconds as defined by sender
     *
     * @var int
     */
    protected int $duration;

    /**
     * Optional. Video thumbnail
     *
     * @var PhotoSize|null
     */
    protected ?PhotoSize $thumb;

    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->width = (int) Arr::get($payload, 'width');
        $this->height = (int) Arr::get($payload, 'height');
        $this->duration = (int) Arr::get($payload, 'duration');
        $this->thumb = Arr::exists($payload, 'thumb') ? new PhotoSize(Arr::get($payload, 'thumb')) : null;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return PhotoSize|null
     */
    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }
}
