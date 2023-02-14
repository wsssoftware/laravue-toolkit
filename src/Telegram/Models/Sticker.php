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
     */
    protected string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used
     * to download or reuse the file.
     */
    protected string $file_unique_id;

    /**
     * Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”. The type of the sticker is independent
     * from its format, which is determined by the fields is_animated and is_video.
     */
    protected StickerType $type;

    /**
     * Sticker width
     */
    protected int $width;

    /**
     * Sticker height
     */
    protected int $height;

    /**
     * True, if the sticker is animated
     */
    protected bool $is_animated;

    /**
     * True, if the sticker is a video sticker
     */
    protected bool $is_video;

    /**
     * Optional. Sticker thumbnail in the .WEBP or .JPG format
     */
    protected ?PhotoSize $thumb;

    /**
     * Optional. Emoji associated with the sticker
     */
    protected ?string $emoji;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     */
    protected ?string $set_name;

    /**
     * Optional. For premium regular stickers, premium animation for the sticker
     */
    protected ?File $premium_animation;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     */
    protected ?MaskPosition $mask_position;

    /**
     * Optional. For custom emoji stickers, unique identifier of the custom emoji
     */
    protected ?string $custom_emoji_id;

    /**
     * Optional. File size in bytes
     */
    protected ?int $file_size;

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

    public function getFileId(): string
    {
        return $this->file_id;
    }

    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    public function getType(): StickerType
    {
        return $this->type;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function isIsAnimated(): bool
    {
        return $this->is_animated;
    }

    public function isIsVideo(): bool
    {
        return $this->is_video;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function getSetName(): ?string
    {
        return $this->set_name;
    }

    public function getPremiumAnimation(): ?File
    {
        return $this->premium_animation;
    }

    public function getMaskPosition(): ?MaskPosition
    {
        return $this->mask_position;
    }

    public function getCustomEmojiId(): ?string
    {
        return $this->custom_emoji_id;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
    }
}
