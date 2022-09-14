<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#game
 */
class Game
{
    /**
     * Title of the game
     *
     * @var string
     */
    protected string $title;

    /**
     * Description of the game
     *
     * @var string
     */
    protected string $description;

    /**
     * of PhotoSize	Photo that will be displayed in the game message in chats.
     *
     * @var PhotoSize[]
     */
    protected array $photo;

    /**
     * Optional. Brief description of the game or high scores included in the game message. Can be automatically edited
     * to include current high scores for the game when the bot calls setGameScore, or manually edited using
     * editMessageText. 0-4096 characters.
     *
     * @var string|null
     */
    protected ?string $text;

    /**
     * Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
     *
     * @var MessageEntity[]|null
     */
    protected ?array $text_entities;

    /**
     * Optional. Animation that will be displayed in the game message in chats. Upload via BotFather
     *
     * @var Animation|null
     */
    protected ?Animation $animation;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->title = Arr::get($payload, 'title');
        $this->description = Arr::get($payload, 'description');
        if (Arr::exists($payload, 'photo')) {
            $this->photo = [];
            foreach (Arr::get($payload, 'photo', []) as $photo) {
                $this->photo[] = new PhotoSize($photo);
            }
        }
        $this->text = Arr::get($payload, 'text');
        if (Arr::exists($payload, 'text_entities')) {
            $this->text_entities = [];
            foreach (Arr::get($payload, 'text_entities', []) as $entity) {
                $this->text_entities[] = new MessageEntity($entity);
            }
        }
        $this->animation = Arr::exists($payload, 'animation') ? new Animation(Arr::get($payload, 'animation')) : null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return array|null
     */
    public function getTextEntities(): ?array
    {
        return $this->text_entities;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }
}
