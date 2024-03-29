<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

abstract class BaseFile
{
    /**
     * 	Identifier for this file, which can be used to download or reuse the file
     */
    protected string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used
     * to download or reuse the file.
     */
    protected string $file_unique_id;

    /**
     * 	Optional. Original filename as defined by sender
     */
    protected ?string $file_name;

    /**
     * 	Optional. MIME type of the file as defined by sender
     *
     * @var ?string
     */
    protected ?string $mime_type;

    /**
     * 	Optional. File size in bytes. It can be bigger than 2^31 and some programming languages may have
     * difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer
     * or double-precision float type are safe for storing this value.
     */
    protected ?int $file_size;

    public function __construct(array $payload)
    {
        $this->file_id = Arr::get($payload, 'file_id');
        $this->file_unique_id = Arr::get($payload, 'file_unique_id');
        $this->file_name = Arr::get($payload, 'file_name');
        $this->mime_type = Arr::get($payload, 'mime_type');
        $this->file_size = Arr::exists($payload, 'file_size') ? intval(Arr::get($payload, 'file_size')) : null;
    }

    public function getFileId(): string
    {
        return $this->file_id;
    }

    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
    }
}
