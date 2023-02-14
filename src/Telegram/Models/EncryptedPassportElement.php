<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement
{
    /**
     * Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”,
     * “address”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”,
     * “temporary_registration”, “phone_number”, “email”.
     */
    protected string $type;

    /**
     * Optional. Base64-encoded encrypted Telegram Passport element data provided by the user, available for
     * “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types.
     * Can be decrypted and verified using the accompanying EncryptedCredentials.
     */
    protected string $data;

    /**
     * Optional. User's verified phone number, available only for “phone_number” type
     */
    protected ?string $phone_number;

    /**
     * Optional. User's verified email address, available only for “email” type
     */
    protected ?string $email;

    /**
     * Optional. Array of encrypted files with documents provided by the user, available for
     * “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types.
     * Files can be decrypted and verified using the accompanying EncryptedCredentials.
     *
     * @var PassportFile[]|null
     */
    protected ?array $files;

    /**
     * Optional. Encrypted file with the front side of the document, provided by the user. Available for “passport”,
     * “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the
     * accompanying EncryptedCredentials.
     */
    protected ?PassportFile $front_side;

    /**
     * Optional. Encrypted file with the reverse side of the document, provided by the user. Available for
     * “driver_license” and “identity_card”. The file can be decrypted and verified using the accompanying
     * EncryptedCredentials.
     */
    protected ?PassportFile $reverse_side;

    /**
     * Optional. Encrypted file with the selfie of the user holding a document, provided by the user; available for
     * “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified
     * using the accompanying EncryptedCredentials.
     */
    protected ?PassportFile $selfie;

    /**
     * Optional. Array of encrypted files with translated versions of documents provided by the user. Available if
     * requested for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be
     * decrypted and verified using the accompanying EncryptedCredentials.
     *
     * @var PassportFile[]|null
     */
    protected ?array $translation;

    /**
     * Base64-encoded element hash for using in PassportElementErrorUnspecified
     */
    protected string $hash;

    public function __construct(array $payload)
    {
        $this->type = Arr::get($payload, 'type');
        $this->data = Arr::get($payload, 'data');
        $this->phone_number = Arr::get($payload, 'phone_number');
        $this->email = Arr::get($payload, 'email');
        if (Arr::exists($payload, 'files')) {
            $this->files = [];
            foreach (Arr::get($payload, 'files', []) as $file) {
                $this->files[] = new PassportFile($file);
            }
        }
        $this->front_side = Arr::exists($payload, 'front_side') ? new PassportFile(Arr::get($payload, 'front_side')) : null;
        $this->reverse_side = Arr::exists($payload, 'reverse_side') ? new PassportFile(Arr::get($payload, 'reverse_side')) : null;
        $this->selfie = Arr::exists($payload, 'selfie') ? new PassportFile(Arr::get($payload, 'selfie')) : null;
        if (Arr::exists($payload, 'translation')) {
            $this->translation = [];
            foreach (Arr::get($payload, 'translation', []) as $file) {
                $this->translation[] = new PassportFile($file);
            }
        }
        $this->hash = Arr::get($payload, 'hash');
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function getFrontSide(): ?PassportFile
    {
        return $this->front_side;
    }

    public function getReverseSide(): ?PassportFile
    {
        return $this->reverse_side;
    }

    public function getSelfie(): ?PassportFile
    {
        return $this->selfie;
    }

    public function getTranslation(): ?array
    {
        return $this->translation;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
