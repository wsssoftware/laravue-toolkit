<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\MessageEntityType;

/**
 * Class Message
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#message
 */
class Message
{
    /**
     * Unique message identifier inside this chat
     *
     * @var int
     */
    protected int $message_id;

    /**
     * Optional. Sender of the message; empty for messages sent to channels. For backward compatibility, the field
     * contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     *
     * @var User|null
     */
    protected ?User $from;

    /**
     * Optional. Sender of the message, sent on behalf of a chat. For example, the channel itself for channel posts, the
     * supergroup itself for messages from anonymous group administrators, the linked channel for messages automatically
     * forwarded to the discussion group. For backward compatibility, the field from contains a fake sender user in
     * non-channel chats, if the message was sent on behalf of a chat.
     *
     * @var Chat|null
     */
    protected ?Chat $sender_chat;

    /**
     * Date the message was sent in Unix time
     *
     * @var Carbon
     */
    protected Carbon $date;

    /**
     * Conversation the message belongs to
     *
     * @var Chat
     */
    protected Chat $chat;

    /**
     * Optional. For forwarded messages, sender of the original message
     *
     * @var User|null
     */
    protected ?User $forward_from;

    /**
     * Optional. For messages forwarded from channels or from anonymous administrators, information about the
     * original sender chat
     *
     * @var Chat|null
     */
    protected ?Chat $forward_from_chat;

    /**
     * Optional. For messages forwarded from channels, identifier of the original message in the channel
     *
     * @var int|null
     */
    protected ?int $forward_from_message_id;

    /**
     * Optional. For forwarded messages that were originally sent in channels or by an anonymous chat administrator,
     * signature of the message sender if present
     *
     * @var string|null
     */
    protected ?string $forward_signature;

    /**
     * Optional. Sender's name for messages forwarded from users who disallow adding a link to their account in
     * forwarded messages
     *
     * @var string|null
     */
    protected ?string $forward_sender_name;

    /**
     * Optional. For forwarded messages, date the original message was sent in Unix time
     *
     * @var Carbon|null
     */
    protected ?Carbon $forward_date;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion
     * group
     *
     * @var bool|null
     */
    protected ?bool $is_automatic_forward;

    /**
     * Optional. For replies, the original message. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it itself is a reply.
     *
     * @var Message|null
     */
    protected ?Message $reply_to_message;

    /**
     * Optional. Bot through which the message was sent
     *
     * @var User|null
     */
    protected ?User $via_bot;

    /**
     * Optional. Date the message was last edited in Unix time
     *
     * @var Carbon|null
     */
    protected ?Carbon $edit_date;

    /**
     * Optional. True, if the message can't be forwarded
     *
     * @var bool|null
     */
    protected ?bool $has_protected_content;

    /**
     * Optional. The unique identifier of a media message group this message belongs to
     *
     * @var string|null
     */
    protected ?string $media_group_id;

    /**
     * Optional. Signature of the post author for messages in channels, or the custom title of an anonymous
     * group administrator
     *
     * @var string|null
     */
    protected ?string $author_signature;

    /**
     * Optional. For text messages, the actual UTF-8 text of the message
     *
     * @var string|null
     */
    protected ?string $text;

    /**
     * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     *
     * @var MessageEntity[]
     */
    protected array $entities = [];

    /**
     * Optional. Message is an animation, information about the animation. For backward compatibility, when this field
     * is set, the document field will also be set
     *
     * @var Animation|null
     */
    protected ?Animation $animation;

    /**
     * Optional. Message is an audio file, information about the file
     *
     * @var Audio|null
     */
    protected ?Audio $audio;

    /**
     * Optional. Message is a general file, information about the file
     *
     * @var Document|null
     */
    protected ?Document $document;

    /**
     * Optional. Message is a photo, available sizes of the photo
     *
     * @var PhotoSize[]|null
     */
    protected ?array $photo;

    /**
     * Optional. Message is a sticker, information about the sticker
     *
     * @var Sticker|null
     */
    protected ?Sticker $sticker;

    /**
     * Optional. Message is a video, information about the video
     *
     * @var Video|null
     */
    protected ?Video $video;

    /**
     * Optional. Message is a video note, information about the video message
     *
     * @var VideoNote|null
     */
    protected ?VideoNote $video_note;

    /**
     * Optional. Message is a voice message, information about the file
     *
     * @var Voice|null
     */
    protected ?Voice $voice;

    /**
     * Optional. Caption for the animation, audio, document, photo, video or voice
     *
     * @var string|null
     */
    protected ?string $caption;

    /**
     * Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
     *
     * @var MessageEntity[]|null
     */
    protected ?array $caption_entities;

    /**
     * Optional. Message is a shared contact, information about the contact
     *
     * @var Contact|null
     */
    protected ?Contact $contact;

    /**
     * Optional. Message is a dice with random value
     *
     * @var Dice|null
     */
    protected ?Dice $dice;

    /**
     * Optional. Message is a game, information about the game. More about games »
     *
     * @var Game|null
     */
    protected ?Game $game;

    /**
     * Optional. Message is a native poll, information about the poll
     *
     * @var Poll|null
     */
    protected ?Poll $poll;

    /**
     * Optional. Message is a venue, information about the venue. For backward compatibility, when this field is set, the location field will also be set
     *
     * @var Venue|null
     */
    protected ?Venue $venue;

    /**
     * Optional. Message is a shared location, information about the location
     *
     * @var Location|null
     */
    protected ?Location $location;

    /**
     * Optional. New members that were added to the group or supergroup and information about them (the bot itself may
     * be one of these members)
     *
     * @var User[]|null
     */
    protected ?array $new_chat_members;

    /**
     * Optional. A member was removed from the group, information about them (this member may be the bot itself)
     *
     * @var User|null
     */
    protected ?User $left_chat_member;

    /**
     * Optional. A chat title was changed to this value
     *
     * @var string|null
     */
    protected ?string $new_chat_title;

    /**
     * Optional. A chat photo was change to this value
     *
     * @var PhotoSize[]|null
     */
    protected ?array $new_chat_photo;

    /**
     * Optional. Service message: the chat photo was deleted
     *
     * @var bool|null
     */
    protected ?bool $delete_chat_photo;

    /**
     * Optional. Service message: the group has been created
     *
     * @var bool|null
     */
    protected ?bool $group_chat_created;

    /**
     * Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     *
     * @var bool|null
     */
    protected ?bool $supergroup_chat_created;

    /**
     * Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel.
     *
     * @var bool|null
     */
    protected ?bool $channel_chat_created;

    /**
     * Optional. Service message: auto-delete timer settings changed in the chat
     *
     * @var MessageAutoDeleteTimerChanged|null
     */
    protected ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed;

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more
     * than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for
     * storing this identifier.
     *
     * @var int|null
     */
    protected ?int $migrate_to_chat_id;

    /**
     * Optional. The supergroup has been migrated from a group with the specified identifier. This number may have more
     * than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for
     * storing this identifier.
     *
     * @var int|null
     */
    protected ?int $migrate_from_chat_id;

    /**
     * Optional. Specified message was pinned. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it is itself a reply.
     *
     * @var Message|null
     */
    protected ?Message $pinned_message;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     *
     * @var Invoice|null
     */
    protected ?Invoice $invoice;

    /**
     * Optional. Message is a service message about a successful payment, information about the payment. More about
     * payments »
     *
     * @var SuccessfulPayment|null
     */
    protected ?SuccessfulPayment $successful_payment;

    /**
     * Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
     *
     * @var string|null
     */
    protected ?string $connected_website;

    /**
     * Optional. Telegram Passport data
     *
     * @var PassportData|null
     */
    protected ?PassportData $passport_data;

    /**
     * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live
     * Location.
     *
     * @var ProximityAlertTriggered|null
     */
    protected ?ProximityAlertTriggered $proximity_alert_triggered;

    /**
     * Optional. Service message: video chat scheduled
     *
     * @var VideoChatScheduled|null
     */
    protected ?VideoChatScheduled $video_chat_scheduled;

    /**
     * Optional. Service message: video chat started
     *
     * @var VideoChatStarted|null
     */
    protected ?VideoChatStarted $video_chat_started;

    /**
     * Optional. Service message: video chat ended
     *
     * @var VideoChatEnded|null
     */
    protected ?VideoChatEnded $video_chat_ended;

    /**
     * Optional. Service message: new participants invited to a video chat
     *
     * @var VideoChatParticipantsInvited|null
     */
    protected ?VideoChatParticipantsInvited $video_chat_participants_invited;

    /**
     * Optional. Service message: data sent by a Web App
     *
     * @var WebAppData|null
     */
    protected ?WebAppData $web_app_data;

    /**
     * Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
     *
     * @var InlineKeyboardMarkup[]|null
     */
    protected ?array $reply_markup;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->message_id = intval(Arr::get($payload, 'message_id'));
        $this->from = Arr::exists($payload, 'from') ? new User($payload['from']) : null;
        $this->sender_chat = Arr::exists($payload, 'sender_chat') ? new User($payload['sender_chat']) : null;
        $this->date = Carbon::createFromTimestamp(Arr::get($payload, 'date'));
        $this->chat = new Chat(Arr::get($payload, 'chat', []));
        $this->forward_from = Arr::exists($payload, 'forward_from') ? new User($payload['forward_from']) : null;
        $this->forward_from_chat = Arr::exists($payload,
            'forward_from_chat') ? new Chat($payload['forward_from_chat']) : null;
        $this->forward_from_message_id = Arr::exists($payload, 'forward_from_message_id') ?
            intval(Arr::get($payload, 'forward_from_message_id')) : null;
        $this->forward_signature = Arr::get($payload, 'forward_signature');
        $this->forward_sender_name = Arr::get($payload, 'forward_sender_name');
        $this->forward_date = Arr::exists($payload, 'forward_date') ?
            Carbon::createFromTimestamp(Arr::get($payload, 'forward_date')) : null;
        $this->is_automatic_forward = Arr::exists($payload, 'is_automatic_forward') ?
            boolval(Arr::get($payload, 'is_automatic_forward')) : null;
        $this->reply_to_message = Arr::exists($payload,
            'reply_to_message') ? new Message($payload['reply_to_message']) : null;
        $this->via_bot = Arr::exists($payload, 'via_bot') ? new User($payload['via_bot']) : null;
        $this->edit_date = Arr::exists($payload, 'edit_date') ?
            Carbon::createFromTimestamp(Arr::get($payload, 'edit_date')) : null;
        $this->has_protected_content = Arr::exists($payload, 'has_protected_content') ?
            boolval(Arr::get($payload, 'has_protected_content')) : null;
        $this->author_signature = Arr::get($payload, 'author_signature');
        $this->text = Arr::get($payload, 'text');
        if (Arr::exists($payload, 'entities')) {
            foreach (Arr::get($payload, 'entities', []) as $entity) {
                $this->entities[] = new MessageEntity($entity);
            }
        }
        $this->animation = Arr::exists($payload, 'animation') ? new Animation($payload['animation']) : null;
        $this->audio = Arr::exists($payload, 'audio') ? new Audio($payload['audio']) : null;
        $this->document = Arr::exists($payload, 'document') ? new Document($payload['document']) : null;
        if (Arr::exists($payload, 'photo')) {
            $this->photo = [];
            foreach (Arr::get($payload, 'photo', []) as $photo) {
                $this->photo[] = new PhotoSize($photo);
            }
        }
        $this->sticker = Arr::exists($payload, 'sticker') ? new Sticker($payload['sticker']) : null;
        $this->video = Arr::exists($payload, 'video') ? new Video($payload['video']) : null;
        $this->video_note = Arr::exists($payload, 'video_note') ? new VideoNote($payload['video_note']) : null;
        $this->voice = Arr::exists($payload, 'voice') ? new Voice($payload['voice']) : null;
        $this->caption = Arr::get($payload, 'caption');
        if (Arr::exists($payload, 'caption_entities')) {
            $this->caption_entities = [];
            foreach (Arr::get($payload, 'caption_entities', []) as $entity) {
                $this->caption_entities[] = new MessageEntity($entity);
            }
        }
        $this->contact = Arr::exists($payload, 'contact') ? new Contact($payload['contact']) : null;
        $this->dice = Arr::exists($payload, 'dice') ? new Dice($payload['dice']) : null;
        $this->game = Arr::exists($payload, 'game') ? new Game($payload['game']) : null;
        $this->poll = Arr::exists($payload, 'poll') ? new Poll($payload['poll']) : null;
        $this->venue = Arr::exists($payload, 'venue') ? new Venue($payload['venue']) : null;
        $this->location = Arr::exists($payload, 'location') ? new Location($payload['location']) : null;
        if (Arr::exists($payload, 'new_chat_members')) {
            $this->new_chat_members = [];
            foreach (Arr::get($payload, 'new_chat_members', []) as $user) {
                $this->new_chat_members[] = new User($user);
            }
        }
        $this->left_chat_member = Arr::exists($payload,
            'left_chat_member') ? new User($payload['left_chat_member']) : null;
        $this->new_chat_title = Arr::get($payload, 'new_chat_title');
        if (Arr::exists($payload, 'new_chat_photo')) {
            $this->new_chat_photo = [];
            foreach (Arr::get($payload, 'new_chat_photo', []) as $photo) {
                $this->new_chat_photo[] = new PhotoSize($photo);
            }
        }
        $this->delete_chat_photo = Arr::exists($payload, 'delete_chat_photo') ?
            boolval(Arr::get($payload, 'delete_chat_photo')) : null;
        $this->group_chat_created = Arr::exists($payload, 'group_chat_created') ?
            boolval(Arr::get($payload, 'group_chat_created')) : null;
        $this->supergroup_chat_created = Arr::exists($payload, 'supergroup_chat_created') ?
            boolval(Arr::get($payload, 'supergroup_chat_created')) : null;
        $this->channel_chat_created = Arr::exists($payload, 'channel_chat_created') ?
            boolval(Arr::get($payload, 'channel_chat_created')) : null;
        $this->message_auto_delete_timer_changed = Arr::exists($payload,
            'message_auto_delete_timer_changed') ? new MessageAutoDeleteTimerChanged($payload['message_auto_delete_timer_changed']) : null;
        $this->migrate_to_chat_id = Arr::exists($payload, 'migrate_to_chat_id') ?
            intval(Arr::get($payload, 'migrate_to_chat_id')) : null;
        $this->migrate_from_chat_id = Arr::exists($payload, 'migrate_from_chat_id') ?
            intval(Arr::get($payload, 'migrate_from_chat_id')) : null;
        $this->pinned_message = Arr::exists($payload,
            'pinned_message') ? new Message($payload['pinned_message']) : null;
        $this->invoice = Arr::exists($payload, 'invoice') ? new Invoice($payload['invoice']) : null;
        $this->successful_payment = Arr::exists($payload,
            'successful_payment') ? new SuccessfulPayment($payload['successful_payment']) : null;
        $this->connected_website = Arr::get($payload, 'connected_website');
        $this->passport_data = Arr::exists($payload,
            'passport_data') ? new SuccessfulPayment($payload['passport_data']) : null;
        $this->proximity_alert_triggered = Arr::exists($payload,
            'proximity_alert_triggered') ? new ProximityAlertTriggered($payload['proximity_alert_triggered']) : null;
        $this->video_chat_scheduled = Arr::exists($payload,
            'video_chat_scheduled') ? new VideoChatScheduled($payload['video_chat_scheduled']) : null;
        $this->video_chat_started = Arr::exists($payload,
            'video_chat_started') ? new VideoChatStarted($payload['video_chat_started']) : null;
        $this->video_chat_ended = Arr::exists($payload,
            'video_chat_ended') ? new VideoChatEnded($payload['video_chat_ended']) : null;
        $this->video_chat_participants_invited = Arr::exists($payload,
            'video_chat_participants_invited') ? new VideoChatParticipantsInvited($payload['video_chat_participants_invited']) : null;
        $this->web_app_data = Arr::exists($payload, 'web_app_data') ? new WebAppData($payload['web_app_data']) : null;

        if (! empty(Arr::get($payload, 'reply_markup'))) {
            $this->setReplyMarkup($payload['reply_markup']);
        }
    }

    /**
     * @param  array  $payload
     * @return void
     */
    protected function setReplyMarkup(array $payload): void
    {
        $items = [];
        $this->extractInlineKeyboard($payload, $items);
        $this->reply_markup = [];
        foreach ($items as $item) {
            $this->reply_markup[] = new InlineKeyboardMarkup($item);
        }
    }

    /**
     * @param  array  $payload
     * @param  array  $items
     * @return void
     */
    protected function extractInlineKeyboard(array $payload, array &$items): void
    {
        if (! empty($payload['text'])) {
            $items[] = $payload;

            return;
        }
        foreach ($payload as $item) {
            if (! empty($item['text'])) {
                $items[] = $item;
            } elseif (is_array($item)) {
                $this->extractInlineKeyboard($item, $items);
            }
        }
    }

    /**
     * @param  string  $command
     * @return bool
     */
    public function isCommandOf(string $command): bool
    {
        $hasCommandEntity = false;
        foreach ($this->entities as $entity) {
            if ($entity->getType() === MessageEntityType::BOT_COMMAND) {
                $hasCommandEntity = true;
            }
        }
        if (!$hasCommandEntity) {
            return false;
        }
        $command = str($command)->trim('/')->prepend('/')->toString();
        $messageText = str($this->text);
        return $messageText->exactly($command) ||
            $messageText->startsWith($command.' ');
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }

    /**
     * @return User|null
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @return Chat|null
     */
    public function getSenderChat(): ?Chat
    {
        return $this->sender_chat;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return User|null
     */
    public function getForwardFrom(): ?User
    {
        return $this->forward_from;
    }

    /**
     * @return Chat|null
     */
    public function getForwardFromChat(): ?Chat
    {
        return $this->forward_from_chat;
    }

    /**
     * @return int|null
     */
    public function getForwardFromMessageId(): ?int
    {
        return $this->forward_from_message_id;
    }

    /**
     * @return string|null
     */
    public function getForwardSignature(): ?string
    {
        return $this->forward_signature;
    }

    /**
     * @return string|null
     */
    public function getForwardSenderName(): ?string
    {
        return $this->forward_sender_name;
    }

    /**
     * @return Carbon|null
     */
    public function getForwardDate(): ?Carbon
    {
        return $this->forward_date;
    }

    /**
     * @return bool|null
     */
    public function getIsAutomaticForward(): ?bool
    {
        return $this->is_automatic_forward;
    }

    /**
     * @return Message|null
     */
    public function getReplyToMessage(): ?Message
    {
        return $this->reply_to_message;
    }

    /**
     * @return User|null
     */
    public function getViaBot(): ?User
    {
        return $this->via_bot;
    }

    /**
     * @return Carbon|null
     */
    public function getEditDate(): ?Carbon
    {
        return $this->edit_date;
    }

    /**
     * @return bool|null
     */
    public function getHasProtectedContent(): ?bool
    {
        return $this->has_protected_content;
    }

    /**
     * @return string|null
     */
    public function getMediaGroupId(): ?string
    {
        return $this->media_group_id;
    }

    /**
     * @return string|null
     */
    public function getAuthorSignature(): ?string
    {
        return $this->author_signature;
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
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    /**
     * @return Audio|null
     */
    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    /**
     * @return Document|null
     */
    public function getDocument(): ?Document
    {
        return $this->document;
    }

    /**
     * @return array|null
     */
    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    /**
     * @return Sticker|null
     */
    public function getSticker(): ?Sticker
    {
        return $this->sticker;
    }

    /**
     * @return Video|null
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @return VideoNote|null
     */
    public function getVideoNote(): ?VideoNote
    {
        return $this->video_note;
    }

    /**
     * @return Voice|null
     */
    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @return array|null
     */
    public function getCaptionEntities(): ?array
    {
        return $this->caption_entities;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @return Dice|null
     */
    public function getDice(): ?Dice
    {
        return $this->dice;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @return Poll|null
     */
    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    /**
     * @return Venue|null
     */
    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @return array|null
     */
    public function getNewChatMembers(): ?array
    {
        return $this->new_chat_members;
    }

    /**
     * @return User|null
     */
    public function getLeftChatMember(): ?User
    {
        return $this->left_chat_member;
    }

    /**
     * @return string|null
     */
    public function getNewChatTitle(): ?string
    {
        return $this->new_chat_title;
    }

    /**
     * @return array|null
     */
    public function getNewChatPhoto(): ?array
    {
        return $this->new_chat_photo;
    }

    /**
     * @return bool|null
     */
    public function getDeleteChatPhoto(): ?bool
    {
        return $this->delete_chat_photo;
    }

    /**
     * @return bool|null
     */
    public function getGroupChatCreated(): ?bool
    {
        return $this->group_chat_created;
    }

    /**
     * @return bool|null
     */
    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroup_chat_created;
    }

    /**
     * @return bool|null
     */
    public function getChannelChatCreated(): ?bool
    {
        return $this->channel_chat_created;
    }

    /**
     * @return MessageAutoDeleteTimerChanged|null
     */
    public function getMessageAutoDeleteTimerChanged(): ?MessageAutoDeleteTimerChanged
    {
        return $this->message_auto_delete_timer_changed;
    }

    /**
     * @return int|null
     */
    public function getMigrateToChatId(): ?int
    {
        return $this->migrate_to_chat_id;
    }

    /**
     * @return int|null
     */
    public function getMigrateFromChatId(): ?int
    {
        return $this->migrate_from_chat_id;
    }

    /**
     * @return Message|null
     */
    public function getPinnedMessage(): ?Message
    {
        return $this->pinned_message;
    }

    /**
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @return SuccessfulPayment|null
     */
    public function getSuccessfulPayment(): ?SuccessfulPayment
    {
        return $this->successful_payment;
    }

    /**
     * @return string|null
     */
    public function getConnectedWebsite(): ?string
    {
        return $this->connected_website;
    }

    /**
     * @return PassportData|null
     */
    public function getPassportData(): ?PassportData
    {
        return $this->passport_data;
    }

    /**
     * @return ProximityAlertTriggered|null
     */
    public function getProximityAlertTriggered(): ?ProximityAlertTriggered
    {
        return $this->proximity_alert_triggered;
    }

    /**
     * @return VideoChatScheduled|null
     */
    public function getVideoChatScheduled(): ?VideoChatScheduled
    {
        return $this->video_chat_scheduled;
    }

    /**
     * @return VideoChatStarted|null
     */
    public function getVideoChatStarted(): ?VideoChatStarted
    {
        return $this->video_chat_started;
    }

    /**
     * @return VideoChatEnded|null
     */
    public function getVideoChatEnded(): ?VideoChatEnded
    {
        return $this->video_chat_ended;
    }

    /**
     * @return VideoChatParticipantsInvited|null
     */
    public function getVideoChatParticipantsInvited(): ?VideoChatParticipantsInvited
    {
        return $this->video_chat_participants_invited;
    }

    /**
     * @return WebAppData|null
     */
    public function getWebAppData(): ?WebAppData
    {
        return $this->web_app_data;
    }

    /**
     * @return InlineKeyboardMarkup[]|null
     */
    public function getReplyMarkup(): ?array
    {
        return $this->reply_markup;
    }
}
