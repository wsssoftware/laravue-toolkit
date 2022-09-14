<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\StickerType;

/**
 * Class Animation
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#sticker
 */
class Sticker
{
    /**
     * Identifier for this file, which can be used to download or reuse the file
     *
     * @var string
     */
    protected string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used
     * to download or reuse the file.
     *
     * @var
     */
    protected string $file_unique_id;

    /**
     * Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”. The type of the sticker is independent
     * from its format, which is determined by the fields is_animated and is_video.
     *
     * @var StickerType
     */
    protected StickerType $type;

    /**
     * Sticker width
     *
     * @var int
     */
    protected int $width;

    /**
     * Sticker height
     *
     * @var int
     */
    protected int $height;

    /**
     * True, if the sticker is animated
     *
     * @var bool
     */
    protected bool $is_animated;

    /**
     * True, if the sticker is a video sticker
     *
     * @var bool
     */
    protected bool $is_video;

    /**
     * Optional. Sticker thumbnail in the .WEBP or .JPG format
     *
     * @var PhotoSize|null
     */
    protected ?PhotoSize $thumb;

    /**
     * Optional. Emoji associated with the sticker
     *
     * @var string|null
     */
    protected ?string $emoji;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     *
     * @var string|null
     */
    protected ?string $set_name;

    /**
     * Optional. For premium regular stickers, premium animation for the sticker
     *
     * @var File|null
     */
    protected ?File $premium_animation;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     *
     * @var MaskPosition|null
     */
    protected ?MaskPosition $mask_position;

    /**
     * Optional. For custom emoji stickers, unique identifier of the custom emoji
     *
     * @var string|null
     */
    protected ?string $custom_emoji_id;

    /**
     * Optional. File size in bytes
     *
     * @var int|null
     */
    protected ?int $file_size;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->file_id = Arr::get($payload, 'file_id');
        $this->file_unique_id = Arr::get($payload, 'file_unique_id');
        $this->type = StickerType::from(Arr::get($payload, 'type'));
        $this->width = (int) Arr::get($payload, 'width');
        $this->height = (int) Arr::get($payload, 'height');
        $this->is_animated = (bool) Arr::get($payload, 'is_animated');
        $this->is_video = (bool) Arr::get($payload, 'is_video');
        $this->thumb = Arr::exists($payload, 'thumb') ? new PhotoSize(Arr::get($payload, 'thumb')) : null;
        $this->emoji = Arr::get($payload, 'emoji');
        $this->set_name = Arr::get($payload, 'set_name');
        $this->premium_animation = Arr::exists($payload, 'premium_animation') ? new File(Arr::get($payload, 'premium_animation')) : null;
        $this->mask_position = Arr::exists($payload, 'mask_position') ? new MaskPosition(Arr::get($payload, 'mask_position')) : null;
        $this->custom_emoji_id = Arr::get($payload, 'custom_emoji_id');
        $this->file_size = (int) Arr::get($payload, 'file_size');
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->file_id;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    /**
     * @return StickerType
     */
    public function getType(): StickerType
    {
        return $this->type;
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
     * @return bool
     */
    public function isIsAnimated(): bool
    {
        return $this->is_animated;
    }

    /**
     * @return bool
     */
    public function isIsVideo(): bool
    {
        return $this->is_video;
    }

    /**
     * @return PhotoSize|null
     */
    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    /**
     * @return string|null
     */
    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    /**
     * @return string|null
     */
    public function getSetName(): ?string
    {
        return $this->set_name;
    }

    /**
     * @return File|null
     */
    public function getPremiumAnimation(): ?File
    {
        return $this->premium_animation;
    }

    /**
     * @return MaskPosition|null
     */
    public function getMaskPosition(): ?MaskPosition
    {
        return $this->mask_position;
    }

    /**
     * @return string|null
     */
    public function getCustomEmojiId(): ?string
    {
        return $this->custom_emoji_id;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->file_size;
    }
}
