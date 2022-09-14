<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Chat
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link  https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto
{

    /**
     * File identifier of small (160x160) chat photo. This file_id can be used only for photo download and only for as
     * long as the photo is not changed.
     *
     * @var string
     */
    protected string $small_file_id;

    /**
     * Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for
     * different bots. Can't be used to download or reuse the file.
     *
     * @var string
     */
    protected string $small_file_unique_id;

    /**
     * File identifier of big (640x640) chat photo. This file_id can be used only for photo download and only for as
     * long as the photo is not changed.
     *
     * @var string
     */
    protected string $big_file_id;

    /**
     * Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different
     * bots. Can't be used to download or reuse the file.
     *
     * @var string
     */
    protected string $big_file_unique_id;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->small_file_id = Arr::get($payload, 'small_file_id', '');
        $this->small_file_unique_id = Arr::get($payload, 'small_file_unique_id', '');
        $this->big_file_id = Arr::get($payload, 'big_file_id', '');
        $this->big_file_unique_id = Arr::get($payload, 'big_file_unique_id', '');
    }

    /**
     * @return string
     */
    public function getSmallFileId(): string
    {
        return $this->small_file_id;
    }

    /**
     * @return string
     */
    public function getSmallFileUniqueId(): string
    {
        return $this->small_file_unique_id;
    }

    /**
     * @return string
     */
    public function getBigFileId(): string
    {
        return $this->big_file_id;
    }

    /**
     * @return string
     */
    public function getBigFileUniqueId(): string
    {
        return $this->big_file_unique_id;
    }
}
