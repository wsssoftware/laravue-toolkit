<?php

namespace Laravue\Flash;

use Laravue\Enums\FlashTypes;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Testing\Assert as PHPUnit;

/**
 * Class Flash
 *
 * Created by allancarvalho in dezembro 13, 2022
 */
class Flash
{
    protected const SESSION_KEY = 'sessionFlash';

    /**
     * @var array
     */
    protected array $messages = [];

    /**
     * @var \Illuminate\Session\SessionManager|\Illuminate\Session\Store
     */
    protected SessionManager|Store $session;

    /**
     * @param  \Illuminate\Session\SessionManager|\Illuminate\Session\Store  $session
     */
    public function __construct(SessionManager|Store $session)
    {
        $this->session = $session;
        if ($this->session->get(self::SESSION_KEY) === null) {
            $this->session->put(self::SESSION_KEY, []);
        }
    }

    /**
     * @param  string  $message
     * @param  string|null  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function default(string $message, ?string $faIcon = null): FlashMessage
    {
        $message = new FlashMessage($message, FlashTypes::DEFAULT, $faIcon);
        $this->session->push(self::SESSION_KEY, $message);

        return $message;
    }

    /**
     * @param  string  $message
     * @param  string  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function success(string $message, string $faIcon = 'circle-check'): FlashMessage
    {
        $message = new FlashMessage($message, FlashTypes::SUCCESS, $faIcon);
        $this->session->push(self::SESSION_KEY, $message);

        return $message;
    }

    /**
     * @param  string  $message
     * @param  string  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function info(string $message, string $faIcon = 'circle-info'): FlashMessage
    {
        $message = new FlashMessage($message, FlashTypes::INFO, $faIcon);
        $this->session->push(self::SESSION_KEY, $message);

        return $message;
    }

    /**
     * @param  string  $message
     * @param  string  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function warning(string $message, string $faIcon = 'triangle-exclamation'): FlashMessage
    {
        $message = new FlashMessage($message, FlashTypes::WARNING, $faIcon);
        $this->session->push(self::SESSION_KEY, $message);

        return $message;
    }

    /**
     * @param  string  $message
     * @param  string  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function error(string $message, string $faIcon = 'diamond-exclamation'): FlashMessage
    {
        $message = new FlashMessage($message, FlashTypes::ERROR, $faIcon);
        $this->session->push(self::SESSION_KEY, $message);

        return $message;
    }

    /**
     * @return void
     */
    public function restoreFlashes(): void
    {
        $this->session->put(self::SESSION_KEY, $this->messages);
    }

    /**
     * @param  bool  $rememberMessages
     * @return array
     */
    public function toArray(bool $rememberMessages = false): array
    {
        $status = $this->session->pull('status');
        if (! empty($status)) {
            $this->default($status);
        }

        /** @var \Laravue\Flash\FlashMessage[] $messages */
        $this->messages =
            $rememberMessages ?
                $this->session->get(self::SESSION_KEY, []) :
                $this->session->pull(self::SESSION_KEY, []);
        $payload = [];
        foreach ($this->messages as $message) {
            $payload[] = $message->toArray();
        }

        return $payload;
    }

    /**
     * @return $this
     */
    public function assertHasSuccess(): static
    {
        return $this->assertHasFlashType(FlashTypes::SUCCESS);
    }

    /**
     * @return $this
     */
    public function assertHasError(): static
    {
        return $this->assertHasFlashType(FlashTypes::ERROR);
    }

    /**
     * @return $this
     */
    public function assertHasInfo(): static
    {
        return $this->assertHasFlashType(FlashTypes::INFO);
    }

    /**
     * @return $this
     */
    public function assertHasWarning(): static
    {
        return $this->assertHasFlashType(FlashTypes::WARNING);
    }

    /**
     * @param  \Laravue\Enums\FlashTypes  $flashTypes
     * @return $this
     */
    public function assertHasFlashType(FlashTypes $flashTypes): static
    {
        $flashMessages = $this->toArray(true);
        $hasFlashMessage = false;
        foreach ($flashMessages as $flashMessage) {
            if ($flashMessage['type'] === $flashTypes->value) {
                $hasFlashMessage = true;
                break;
            }
        }
        if (! $hasFlashMessage) {
            PHPUnit::fail(sprintf('Flash of type "%s" not found in flash messages', $flashTypes->value));
        }

        return $this;
    }

    /**
     * @param  string  $message
     * @return \Laravue\Flash\Flash
     */
    public function assertMessageContain(string $message): static
    {
        $flashMessages = $this->toArray(true);
        $hasFlashMessage = false;
        foreach ($flashMessages as $flashMessage) {
            $flashMessageString = str($flashMessage['message']);
            if ($flashMessageString->contains($message)) {
                $hasFlashMessage = true;
                break;
            }
        }
        if (! $hasFlashMessage) {
            PHPUnit::fail(sprintf('Message "%s" not found in flash messages', $message));
        }

        return $this;
    }

    /**
     * @param  string  $message
     * @return \Laravue\Flash\Flash
     */
    public function assertMessageEqual(string $message): static
    {
        $flashMessages = $this->toArray(true);
        $hasFlashMessage = false;
        foreach ($flashMessages as $flashMessage) {
            if ($flashMessage['message'] === $message) {
                $hasFlashMessage = true;
                break;
            }
        }
        if (! $hasFlashMessage) {
            PHPUnit::fail(sprintf('Message "%s" not found in flash messages', $message));
        }

        return $this;
    }
}
