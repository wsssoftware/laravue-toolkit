<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials
{

    /**
     * Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and secrets required for
     * EncryptedPassportElement decryption and authentication
     *
     * @var string
     */
    protected string $data;

    /**
     * Base64-encoded data hash for data authentication
     *
     * @var string
     */
    protected string $hash;

    /**
     * Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
     *
     * @var string
     */
    protected string $secret;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->data = Arr::get($payload, 'data');
        $this->hash = Arr::get($payload, 'hash');
        $this->secret = Arr::get($payload, 'secret');
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
