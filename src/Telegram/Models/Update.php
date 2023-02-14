<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\UpdateType;

/**
 * Class Animation
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#update
 */
class Update
{
    /**
     * The update's unique identifier. Update identifiers start from a certain positive number and increase
     * sequentially. This ID becomes especially handy if you're using webhooks, since it allows you to ignore repeated
     * updates or to restore the correct update sequence, should they get out of order. If there are no new updates for
     * at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
     */
    protected int $update_id;

    /**
     * Optional. New incoming message of any kind - text, photo, sticker, etc.
     */
    protected ?Message $message;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     */
    protected ?Message $edited_message;

    /**
     * Optional. New incoming channel post of any kind - text, photo, sticker, etc.
     */
    protected ?Message $channel_post;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     */
    protected ?Message $edited_channel_post;

    /**
     * Optional. New incoming inline query
     */
    protected ?InlineQuery $inline_query;

    /**
     * Optional. The result of an inline query that was chosen by a user and sent to their chat partner. Please see our
     * documentation on the feedback collecting for details on how to enable these updates for your bot.
     */
    protected ?ChosenInlineResult $chosen_inline_result;

    /**
     * Optional. New incoming callback query
     */
    protected ?CallbackQuery $callback_query;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     */
    protected ?ShippingQuery $shipping_query;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     */
    protected ?PreCheckoutQuery $pre_checkout_query;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     */
    protected ?Poll $poll;

    /**
     * Optional. A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were
     * sent by the bot itself.
     */
    protected ?PollAnswer $poll_answer;

    /**
     * Optional. The bot's chat member status was updated in a chat. For private chats, this update is received only
     * when the bot is blocked or unblocked by the user.
     */
    protected ?ChatMemberUpdated $my_chat_member;

    /**
     * Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must
     * explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
     */
    protected ?ChatMemberUpdated $chat_member;

    /**
     * Optional. A request to join the chat has been sent. The bot must have the can_invite_users administrator right in the chat to receive these updates.
     */
    protected ?ChatJoinRequest $chat_join_request;

    public function __construct(array $payload)
    {
        $this->update_id = (int) Arr::get($payload, 'update_id');
        $this->message = Arr::has($payload, 'message') ? new Message(Arr::get($payload, 'message')) : null;
        $this->edited_message = Arr::has($payload, 'edited_message') ? new Message(Arr::get($payload,
            'edited_message')) : null;
        $this->channel_post = Arr::has($payload, 'channel_post') ? new Message(Arr::get($payload,
            'channel_post')) : null;
        $this->edited_channel_post = Arr::has($payload, 'edited_channel_post') ? new Message(Arr::get($payload,
            'edited_channel_post')) : null;
        $this->inline_query = Arr::has($payload, 'inline_query') ? new InlineQuery(Arr::get($payload,
            'inline_query')) : null;
        $this->chosen_inline_result = Arr::has($payload,
            'chosen_inline_result') ? new ChosenInlineResult(Arr::get($payload, 'chosen_inline_result')) : null;
        $this->callback_query = Arr::has($payload, 'callback_query') ? new CallbackQuery(Arr::get($payload,
            'callback_query')) : null;
        $this->shipping_query = Arr::has($payload, 'shipping_query') ? new ShippingQuery(Arr::get($payload,
            'shipping_query')) : null;
        $this->pre_checkout_query = Arr::has($payload, 'pre_checkout_query') ? new PreCheckoutQuery(Arr::get($payload,
            'pre_checkout_query')) : null;
        $this->poll = Arr::has($payload, 'poll') ? new Poll(Arr::get($payload, 'poll')) : null;
        $this->poll_answer = Arr::has($payload, 'poll_answer') ? new PollAnswer(Arr::get($payload,
            'poll_answer')) : null;
        $this->my_chat_member = Arr::has($payload, 'my_chat_member') ? new ChatMemberUpdated(Arr::get($payload,
            'my_chat_member')) : null;
        $this->chat_member = Arr::has($payload, 'chat_member') ? new ChatMemberUpdated(Arr::get($payload,
            'chat_member')) : null;
        $this->chat_join_request = Arr::has($payload, 'chat_join_request') ? new ChatJoinRequest(Arr::get($payload,
            'chat_join_request')) : null;
    }

    public function getUpdateType(): UpdateType
    {
        return match (true) {
            ! empty($this->message) => UpdateType::MESSAGE,
            ! empty($this->channel_post) => UpdateType::CHANNEL_POST,
            ! empty($this->edited_channel_post) => UpdateType::EDITED_CHANNEL_POST,
            ! empty($this->inline_query) => UpdateType::INLINE_QUERY,
            ! empty($this->chosen_inline_result) => UpdateType::CHOSEN_INLINE_RESULT,
            ! empty($this->callback_query) => UpdateType::CALLBACK_QUERY,
            ! empty($this->shipping_query) => UpdateType::SHIPPING_QUERY,
            ! empty($this->pre_checkout_query) => UpdateType::PRE_CHECKOUT_QUERY,
            ! empty($this->poll) => UpdateType::POLL,
            ! empty($this->poll_answer) => UpdateType::POLL_ANSWER,
            ! empty($this->my_chat_member) => UpdateType::MY_CHAT_MEMBER,
            ! empty($this->chat_member) => UpdateType::CHAT_MEMBER,
            ! empty($this->chat_join_request) => UpdateType::CHAT_JOIN_REQUEST,
        };
    }

    public function getUpdateId(): int
    {
        return $this->update_id;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function getEditedMessage(): ?Message
    {
        return $this->edited_message;
    }

    public function getChannelPost(): ?Message
    {
        return $this->channel_post;
    }

    public function getEditedChannelPost(): ?Message
    {
        return $this->edited_channel_post;
    }

    public function getInlineQuery(): ?InlineQuery
    {
        return $this->inline_query;
    }

    public function getChosenInlineResult(): ?ChosenInlineResult
    {
        return $this->chosen_inline_result;
    }

    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callback_query;
    }

    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shipping_query;
    }

    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->pre_checkout_query;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function getPollAnswer(): ?PollAnswer
    {
        return $this->poll_answer;
    }

    public function getMyChatMember(): ?ChatMemberUpdated
    {
        return $this->my_chat_member;
    }

    public function getChatMember(): ?ChatMemberUpdated
    {
        return $this->chat_member;
    }

    public function getChatJoinRequest(): ?ChatJoinRequest
    {
        return $this->chat_join_request;
    }
}
