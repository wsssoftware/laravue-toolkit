<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class InlineKeyboardMarkup
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup
{

    /**
     * Label text on the button
     *
     * @var string
     */
    protected string $text;

    /**
     * Optional. HTTP or tg:// URL to be opened when the button is pressed. Links tg://user?id=<user_id> can be used to
     * mention a user by their ID without using a username, if this is allowed by their privacy settings.
     *
     * @var string|null
     */
    protected ?string $url;

    /**
     * Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
     *
     * @var string|null
     */
    protected ?string $callback_data;

    /**
     * Optional. Description of the Web App that will be launched when the user presses the button. The Web App will be
     * able to send an arbitrary message on behalf of the user using the method answerWebAppQuery. Available only in
     * private chats between a user and the bot.
     *
     * @var WebAppInfo|null
     */
    protected ?WebAppInfo $web_app;

    /**
     * Optional. An HTTPS URL used to automatically authorize the user. Can be used as a replacement for the Telegram
     * Login Widget.
     *
     * @var LoginUrl|null
     */
    protected ?LoginUrl $login_url;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and
     * insert the bot's username and the specified inline query in the input field. May be empty, in which case just the
     * bot's username will be inserted.
     *
     * @note This offers an easy way for users to start using your bot in inline mode when they are currently in a
     * private chat with it. Especially useful when combined with switch_pm… actions - in this case the user will be
     * automatically returned to the chat they switched from, skipping the chat selection screen.
     *
     * @var string|null
     */
    protected ?string $switch_inline_query;

    /**
     * Optional. If set, pressing the button will insert the bot's username and the specified inline query in the
     * current chat's input field. May be empty, in which case only the bot's username will be inserted.
     *
     * This offers aquick way for the user to open your bot in inline mode in the same chat - good for selecting
     * something from multiple options.
     *
     * @var string|null
     */
    protected ?string $switch_inline_query_current_chat;

    /**
     * Optional. Description of the game that will be launched when the user presses the button.
     *
     * @note This type of button must always be the first button in the first row.
     *
     * @var CallbackGame|null
     */
    protected ?CallbackGame $callback_game;

    /**
     * Optional. Specify True, to send a Pay button.
     *
     * @note This type of button must always be the first button in the first row and can only be used in invoice
     * messages.
     *
     * @var bool|null
     */
    protected ?bool $pay;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->text = Arr::get($payload, 'text');
        $this->url = Arr::get($payload, 'url');
        $this->callback_data = Arr::get($payload, 'callback_data');
        $this->web_app = Arr::exists($payload, 'web_app') ? new WebAppInfo(Arr::get($payload, 'web_app')) : null;
        $this->login_url = Arr::exists($payload, 'login_url') ? new LoginUrl(Arr::get($payload, 'login_url')) : null;
        $this->switch_inline_query = Arr::get($payload, 'switch_inline_query');
        $this->switch_inline_query_current_chat = Arr::get($payload, 'switch_inline_query_current_chat');
        $this->callback_game = Arr::exists($payload, 'callback_game') ? new CallbackGame(Arr::get($payload, 'callback_game')) : null;
        $this->pay = Arr::exists($payload, 'pay') ? (bool) Arr::get($payload, 'pay') : null;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getCallbackData(): ?string
    {
        return $this->callback_data;
    }

    /**
     * @return WebAppInfo|null
     */
    public function getWebApp(): ?WebAppInfo
    {
        return $this->web_app;
    }

    /**
     * @return LoginUrl|null
     */
    public function getLoginUrl(): ?LoginUrl
    {
        return $this->login_url;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQuery(): ?string
    {
        return $this->switch_inline_query;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQueryCurrentChat(): ?string
    {
        return $this->switch_inline_query_current_chat;
    }

    /**
     * @return CallbackGame|null
     */
    public function getCallbackGame(): ?CallbackGame
    {
        return $this->callback_game;
    }

    /**
     * @return bool|null
     */
    public function getPay(): ?bool
    {
        return $this->pay;
    }
}
