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
     */
    protected int $message_id;

    /**
     * Optional. Sender of the message; empty for messages sent to channels. For backward compatibility, the field
     * contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     */
    protected ?User $from;

    /**
     * Optional. Sender of the message, sent on behalf of a chat. For example, the channel itself for channel posts, the
     * supergroup itself for messages from anonymous group administrators, the linked channel for messages automatically
     * forwarded to the discussion group. For backward compatibility, the field from contains a fake sender user in
     * non-channel chats, if the message was sent on behalf of a chat.
     */
    protected ?Chat $sender_chat;

    /**
     * Date the message was sent in Unix time
     */
    protected Carbon $date;

    /**
     * Conversation the message belongs to
     */
    protected Chat $chat;

    /**
     * Optional. For forwarded messages, sender of the original message
     */
    protected ?User $forward_from;

    /**
     * Optional. For messages forwarded from channels or from anonymous administrators, information about the
     * original sender chat
     */
    protected ?Chat $forward_from_chat;

    /**
     * Optional. For messages forwarded from channels, identifier of the original message in the channel
     */
    protected ?int $forward_from_message_id;

    /**
     * Optional. For forwarded messages that were originally sent in channels or by an anonymous chat administrator,
     * signature of the message sender if present
     */
    protected ?string $forward_signature;

    /**
     * Optional. Sender's name for messages forwarded from users who disallow adding a link to their account in
     * forwarded messages
     */
    protected ?string $forward_sender_name;

    /**
     * Optional. For forwarded messages, date the original message was sent in Unix time
     */
    protected ?Carbon $forward_date;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion
     * group
     */
    protected ?bool $is_automatic_forward;

    /**
     * Optional. For replies, the original message. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it itself is a reply.
     */
    protected ?Message $reply_to_message;

    /**
     * Optional. Bot through which the message was sent
     */
    protected ?User $via_bot;

    /**
     * Optional. Date the message was last edited in Unix time
     */
    protected ?Carbon $edit_date;

    /**
     * Optional. True, if the message can't be forwarded
     */
    protected ?bool $has_protected_content;

    /**
     * Optional. The unique identifier of a media message group this message belongs to
     */
    protected ?string $media_group_id;

    /**
     * Optional. Signature of the post author for messages in channels, or the custom title of an anonymous
     * group administrator
     */
    protected ?string $author_signature;

    /**
     * Optional. For text messages, the actual UTF-8 text of the message
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
     */
    protected ?Animation $animation;

    /**
     * Optional. Message is an audio file, information about the file
     */
    protected ?Audio $audio;

    /**
     * Optional. Message is a general file, information about the file
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
     */
    protected ?Sticker $sticker;

    /**
     * Optional. Message is a video, information about the video
     */
    protected ?Video $video;

    /**
     * Optional. Message is a video note, information about the video message
     */
    protected ?VideoNote $video_note;

    /**
     * Optional. Message is a voice message, information about the file
     */
    protected ?Voice $voice;

    /**
     * Optional. Caption for the animation, audio, document, photo, video or voice
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
     */
    protected ?Contact $contact;

    /**
     * Optional. Message is a dice with random value
     */
    protected ?Dice $dice;

    /**
     * Optional. Message is a game, information about the game. More about games »
     */
    protected ?Game $game;

    /**
     * Optional. Message is a native poll, information about the poll
     */
    protected ?Poll $poll;

    /**
     * Optional. Message is a venue, information about the venue. For backward compatibility, when this field is set, the location field will also be set
     */
    protected ?Venue $venue;

    /**
     * Optional. Message is a shared location, information about the location
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
     */
    protected ?User $left_chat_member;

    /**
     * Optional. A chat title was changed to this value
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
     */
    protected ?bool $delete_chat_photo;

    /**
     * Optional. Service message: the group has been created
     */
    protected ?bool $group_chat_created;

    /**
     * Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     */
    protected ?bool $supergroup_chat_created;

    /**
     * Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel.
     */
    protected ?bool $channel_chat_created;

    /**
     * Optional. Service message: auto-delete timer settings changed in the chat
     */
    protected ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed;

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more
     * than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for
     * storing this identifier.
     */
    protected ?int $migrate_to_chat_id;

    /**
     * Optional. The supergroup has been migrated from a group with the specified identifier. This number may have more
     * than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for
     * storing this identifier.
     */
    protected ?int $migrate_from_chat_id;

    /**
     * Optional. Specified message was pinned. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it is itself a reply.
     */
    protected ?Message $pinned_message;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     */
    protected ?Invoice $invoice;

    /**
     * Optional. Message is a service message about a successful payment, information about the payment. More about
     * payments »
     */
    protected ?SuccessfulPayment $successful_payment;

    /**
     * Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
     */
    protected ?string $connected_website;

    /**
     * Optional. Telegram Passport data
     */
    protected ?PassportData $passport_data;

    /**
     * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live
     * Location.
     */
    protected ?ProximityAlertTriggered $proximity_alert_triggered;

    /**
     * Optional. Service message: video chat scheduled
     */
    protected ?VideoChatScheduled $video_chat_scheduled;

    /**
     * Optional. Service message: video chat started
     */
    protected ?VideoChatStarted $video_chat_started;

    /**
     * Optional. Service message: video chat ended
     */
    protected ?VideoChatEnded $video_chat_ended;

    /**
     * Optional. Service message: new participants invited to a video chat
     */
    protected ?VideoChatParticipantsInvited $video_chat_participants_invited;

    /**
     * Optional. Service message: data sent by a Web App
     */
    protected ?WebAppData $web_app_data;

    /**
     * Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
     *
     * @var InlineKeyboardMarkup[]|null
     */
    protected ?array $reply_markup;

    public function __construct(array $payload)
    {
        $this->message_id = intval(Arr::get($payload, 'message_id'));
        $this->from = Arr::exists($payload, 'from') ? new User($payload['from']) : null;
        $this->sender_chat = Arr::exists($payload, 'sender_chat') ? new Chat($payload['sender_chat']) : null;
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

    protected function setReplyMarkup(array $payload): void
    {
        $items = [];
        $this->extractInlineKeyboard($payload, $items);
        $this->reply_markup = [];
        foreach ($items as $item) {
            $this->reply_markup[] = new InlineKeyboardMarkup($item);
        }
    }

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

    public function isCommandOf(string $command): bool
    {
        $commands = [];
        $command = str($command)->trim('/')->prepend('/')->toString();
        $messageText = str($this->text);
        foreach ($this->entities as $entity) {
            if ($entity->getType() === MessageEntityType::BOT_COMMAND) {
                $commands[] = $messageText->substr($entity->getOffset(), $entity->getLength())->toString();
            }
        }
        if (empty($commands)) {
            return false;
        }

        return in_array($command, $commands);
    }

    public function getMessageId(): int
    {
        return $this->message_id;
    }

    public function getFrom(): ?User
    {
        return $this->from;
    }

    public function getSenderChat(): ?Chat
    {
        return $this->sender_chat;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getForwardFrom(): ?User
    {
        return $this->forward_from;
    }

    public function getForwardFromChat(): ?Chat
    {
        return $this->forward_from_chat;
    }

    public function getForwardFromMessageId(): ?int
    {
        return $this->forward_from_message_id;
    }

    public function getForwardSignature(): ?string
    {
        return $this->forward_signature;
    }

    public function getForwardSenderName(): ?string
    {
        return $this->forward_sender_name;
    }

    public function getForwardDate(): ?Carbon
    {
        return $this->forward_date;
    }

    public function getIsAutomaticForward(): ?bool
    {
        return $this->is_automatic_forward;
    }

    public function getReplyToMessage(): ?Message
    {
        return $this->reply_to_message;
    }

    public function getViaBot(): ?User
    {
        return $this->via_bot;
    }

    public function getEditDate(): ?Carbon
    {
        return $this->edit_date;
    }

    public function getHasProtectedContent(): ?bool
    {
        return $this->has_protected_content;
    }

    public function getMediaGroupId(): ?string
    {
        return $this->media_group_id;
    }

    public function getAuthorSignature(): ?string
    {
        return $this->author_signature;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getEntities(): ?array
    {
        return $this->entities;
    }

    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    public function getSticker(): ?Sticker
    {
        return $this->sticker;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function getVideoNote(): ?VideoNote
    {
        return $this->video_note;
    }

    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function getCaptionEntities(): ?array
    {
        return $this->caption_entities;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function getDice(): ?Dice
    {
        return $this->dice;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getNewChatMembers(): ?array
    {
        return $this->new_chat_members;
    }

    public function getLeftChatMember(): ?User
    {
        return $this->left_chat_member;
    }

    public function getNewChatTitle(): ?string
    {
        return $this->new_chat_title;
    }

    public function getNewChatPhoto(): ?array
    {
        return $this->new_chat_photo;
    }

    public function getDeleteChatPhoto(): ?bool
    {
        return $this->delete_chat_photo;
    }

    public function getGroupChatCreated(): ?bool
    {
        return $this->group_chat_created;
    }

    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroup_chat_created;
    }

    public function getChannelChatCreated(): ?bool
    {
        return $this->channel_chat_created;
    }

    public function getMessageAutoDeleteTimerChanged(): ?MessageAutoDeleteTimerChanged
    {
        return $this->message_auto_delete_timer_changed;
    }

    public function getMigrateToChatId(): ?int
    {
        return $this->migrate_to_chat_id;
    }

    public function getMigrateFromChatId(): ?int
    {
        return $this->migrate_from_chat_id;
    }

    public function getPinnedMessage(): ?Message
    {
        return $this->pinned_message;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function getSuccessfulPayment(): ?SuccessfulPayment
    {
        return $this->successful_payment;
    }

    public function getConnectedWebsite(): ?string
    {
        return $this->connected_website;
    }

    public function getPassportData(): ?PassportData
    {
        return $this->passport_data;
    }

    public function getProximityAlertTriggered(): ?ProximityAlertTriggered
    {
        return $this->proximity_alert_triggered;
    }

    public function getVideoChatScheduled(): ?VideoChatScheduled
    {
        return $this->video_chat_scheduled;
    }

    public function getVideoChatStarted(): ?VideoChatStarted
    {
        return $this->video_chat_started;
    }

    public function getVideoChatEnded(): ?VideoChatEnded
    {
        return $this->video_chat_ended;
    }

    public function getVideoChatParticipantsInvited(): ?VideoChatParticipantsInvited
    {
        return $this->video_chat_participants_invited;
    }

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
