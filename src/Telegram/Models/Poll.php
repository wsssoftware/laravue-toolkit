<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\PollType;

/**
 * Class Audio
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#poll
 */
class Poll
{
    /**
     * Unique poll identifier
     *
     * @var string
     */
    protected string $id;

    /**
     * Poll question, 1-300 characters
     *
     * @var string
     */
    protected string $question;

    /**
     * List of poll options
     *
     * @var PollOption[]
     */
    protected array $options = [];

    /**
     * Total number of users that voted in the poll
     *
     * @var int
     */
    protected int $total_voter_count;

    /**
     * True, if the poll is closed
     *
     * @var bool
     */
    protected bool $is_closed;

    /**
     * True, if the poll is anonymous
     *
     * @var bool
     */
    protected bool $is_anonymous;

    /**
     * Poll type, currently can be “regular” or “quiz”
     *
     * @var PollType
     */
    protected PollType $type;

    /**
     * True, if the poll allows multiple answers
     *
     * @var bool
     */
    protected bool $allows_multiple_answers;

    /**
     * Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are
     * closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
     *
     * @var int|null
     */
    protected ?int $correct_option_id;

    /**
     * Optional. Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters
     *
     * @var string|null
     */
    protected ?string $explanation;

    /**
     * Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
     *
     * @var MessageEntity[]|null
     */
    protected ?array $explanation_entities;

    /**
     * Optional. Amount of time in seconds the poll will be active after creation
     *
     * @var int|null
     */
    protected ?int $open_period;

    /**
     * Optional. Point in time (Unix timestamp) when the poll will be automatically closed
     *
     * @var Carbon
     */
    protected Carbon $close_date;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->id = Arr::get($payload, 'id');
        $this->question = Arr::get($payload, 'question');
        foreach (Arr::get($payload, 'options', []) as $option) {
            $this->options[] = new PollOption($option);
        }
        $this->total_voter_count = (int) Arr::get($payload, 'total_voter_count');
        $this->is_closed = (bool) Arr::get($payload, 'is_closed');
        $this->is_anonymous = (bool) Arr::get($payload, 'is_anonymous');
        $this->type = PollType::from(Arr::get($payload, 'type'));
        $this->allows_multiple_answers = (bool) Arr::get($payload, 'allows_multiple_answers');
        $this->correct_option_id = Arr::exists($payload, 'correct_option_id') ? (int) Arr::get($payload, 'correct_option_id') : null;
        $this->explanation = Arr::get($payload, 'explanation');
        if (Arr::exists($payload, 'explanation_entities')) {
            $this->explanation_entities = [];
            foreach (Arr::get($payload, 'explanation_entities', []) as $entity) {
                $this->explanation_entities[] = new MessageEntity($entity);
            }
        }
        $this->open_period = Arr::exists($payload, 'open_period') ? (int) Arr::get($payload, 'open_period') : null;
        $this->close_date = Arr::exists($payload, 'close_date') ? Carbon::createFromTimestamp(Arr::get($payload, 'close_date')) : null;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return int
     */
    public function getTotalVoterCount(): int
    {
        return $this->total_voter_count;
    }

    /**
     * @return bool
     */
    public function isIsClosed(): bool
    {
        return $this->is_closed;
    }

    /**
     * @return bool
     */
    public function isIsAnonymous(): bool
    {
        return $this->is_anonymous;
    }

    /**
     * @return PollType
     */
    public function getType(): PollType
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isAllowsMultipleAnswers(): bool
    {
        return $this->allows_multiple_answers;
    }

    /**
     * @return int|null
     */
    public function getCorrectOptionId(): ?int
    {
        return $this->correct_option_id;
    }

    /**
     * @return string|null
     */
    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    /**
     * @return array|null
     */
    public function getExplanationEntities(): ?array
    {
        return $this->explanation_entities;
    }

    /**
     * @return int|null
     */
    public function getOpenPeriod(): ?int
    {
        return $this->open_period;
    }

    /**
     * @return Carbon
     */
    public function getCloseDate(): Carbon
    {
        return $this->close_date;
    }
}
