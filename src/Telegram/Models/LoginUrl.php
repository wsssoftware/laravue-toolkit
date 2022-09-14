<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl
{
    /**
     * An HTTPS URL to be opened with user authorization data added to the query string when the button is pressed. If
     * the user refuses to provide authorization data, the original URL without information about the user will be
     * opened. The data added is the same as described in Receiving authorization data.
     *
     * @note You must always check the hash of the received data to verify the authentication and the integrity of the
     * data as described in Checking authorization.
     *
     * @var string
     */
    protected string $url;

    /**
     * Optional. New text of the button in forwarded messages.
     *
     * @var string|null
     */
    protected ?string $forward_text;

    /**
     * Optional. Username of a bot, which will be used for user authorization. See Setting up a bot for more details. If
     * not specified, the current bot's username will be assumed. The url's domain must be the same as the domain linked
     * with the bot. See Linking your domain to the bot for more details.
     *
     * @var string|null
     */
    protected ?string $bot_username;

    /**
     * Optional. Pass True to request the permission for your bot to send messages to the user.
     *
     * @var bool|null
     */
    protected ?bool $request_write_access;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->url = Arr::get($payload, 'url');
        $this->forward_text = Arr::get($payload, 'forward_text');
        $this->bot_username = Arr::get($payload, 'bot_username');
        $this->request_write_access = Arr::exists($payload, 'request_write_access') ?
            (bool) Arr::get($payload, 'request_write_access') : null;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getForwardText(): ?string
    {
        return $this->forward_text;
    }

    /**
     * @return string|null
     */
    public function getBotUsername(): ?string
    {
        return $this->bot_username;
    }

    /**
     * @return bool|null
     */
    public function getRequestWriteAccess(): ?bool
    {
        return $this->request_write_access;
    }
}
