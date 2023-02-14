<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#audio
 */
class Audio extends BaseFile
{
    /**
     * Duration of the audio in seconds as defined by sender
     */
    protected int $duration;

    /**
     * Optional. Performer of the audio as defined by sender or by audio tags
     */
    protected ?string $performer;

    /**
     * Optional. Title of the audio as defined by sender or by audio tags
     */
    protected ?string $title;

    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->duration = intval(Arr::get($payload, 'duration'));
        $this->performer = Arr::get($payload, 'performer');
        $this->title = Arr::get($payload, 'title');
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getPerformer(): ?string
    {
        return $this->performer;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
