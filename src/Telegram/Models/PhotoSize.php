<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Animation
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#photosize
 */
class PhotoSize
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
     * Photo width
     */
    protected int $width;

    /**
     * Photo height
     */
    protected int $height;

    /**
     * Optional. File size in bytes
     */
    protected ?int $file_size;

    public function __construct(array $payload)
    {
        $this->file_id = Arr::get($payload, 'file_id');
        $this->file_unique_id = Arr::get($payload, 'file_unique_id');
        $this->width = (int) Arr::get($payload, 'width');
        $this->height = (int) Arr::get($payload, 'height');
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

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
    }
}
