<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#videonote
 */
class VideoNote
{
    /**
     * Identifier for this file, which can be used to download or reuse the file
     */
    protected string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used
     * to download or reuse the file.
     */
    protected string $file_unique_id;

    /**
     * Video width and height (diameter of the video message) as defined by sender
     */
    protected int $length;

    /**
     * Duration of the video in seconds as defined by sender
     */
    protected int $duration;

    /**
     * Optional. Video thumbnail
     */
    protected ?PhotoSize $thumb;

    /**
     * Optional. File size in bytes
     */
    protected ?int $file_size;

    public function __construct(array $payload)
    {
        $this->file_id = Arr::get($payload, 'file_id');
        $this->file_unique_id = Arr::get($payload, 'file_unique_id');
        $this->length = (int) Arr::get($payload, 'length');
        $this->duration = (int) Arr::get($payload, 'duration');
        $this->thumb = Arr::exists($payload, 'thumb') ? new PhotoSize(Arr::get($payload, 'thumb')) : null;
        $this->file_size = Arr::exists($payload, 'file_size') ? (int) Arr::get($payload, 'file_size') : null;
    }

    public function getFileId(): string
    {
        return $this->file_id;
    }

    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
    }
}
