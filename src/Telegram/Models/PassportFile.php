<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#passportfile
 */
class PassportFile
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
     * File size in bytes
     */
    protected int $file_size;

    /**
     * Unix time when the file was uploaded
     */
    protected Carbon $file_date;

    public function __construct(array $payload)
    {
        $this->file_id = Arr::get($payload, 'file_id');
        $this->file_unique_id = Arr::get($payload, 'file_unique_id');
        $this->file_size = (int) Arr::get($payload, 'file_size');
        $this->file_date = Carbon::createFromTimestamp(Arr::get($payload, 'file_date'));
    }

    public function getFileId(): string
    {
        return $this->file_id;
    }

    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    public function getFileSize(): int
    {
        return $this->file_size;
    }

    public function getFileDate(): Carbon
    {
        return $this->file_date;
    }
}
