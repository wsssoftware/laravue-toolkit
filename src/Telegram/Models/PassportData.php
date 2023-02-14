<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class PassportData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#passportdata
 */
class PassportData
{
    /**
     * Array with information about documents and other Telegram Passport elements that was shared with the bot
     *
     * @var EncryptedPassportElement[]|null
     */
    protected array $data;

    /**
     * Encrypted credentials required to decrypt the data
     */
    protected EncryptedCredentials $credentials;

    public function __construct(array $payload)
    {
        if (Arr::exists($payload, 'data')) {
            $this->data = [];
            foreach (Arr::get($payload, 'data', []) as $data) {
                $this->data[] = new EncryptedPassportElement($data);
            }
        }
        $this->credentials = new EncryptedCredentials(Arr::get($payload, 'credentials', []));
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getCredentials(): EncryptedCredentials
    {
        return $this->credentials;
    }
}
