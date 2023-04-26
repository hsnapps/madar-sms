<?php

namespace NotificationChannels\Madar;

use Illuminate\Support\Arr;

class MadarMessage
{
    protected $payload = [];

    /**
     * @param  string  $message
     */
    public function __construct(string $message = '')
    {
        $this->payload['msg'] = $message;
        $this->payload['By'] = 'standard';
    }

    /**
     * Get the payload value for a given key.
     *
     * @param  string  $key
     * @return mixed|null
     */
    public function getPayloadValue(string $key)
    {
        return $this->payload[$key] ?? null;
    }

    /**
     * Return new SMS77Message object.
     *
     * @param  string  $message
     */
    public static function create(string $message = ''): self
    {
        return new self($message);
    }

    /**
     * Returns if recipient number is given or not.
     *
     * @return bool
     */
    public function hasToNumber(): bool
    {
        return isset($this->payload['numbers']);
    }

    /**
     * Return payload.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->payload;
    }

    /**
     * Set message content.
     *
     * @param  string  $message
     */
    public function content(string $message): self
    {
        $this->payload['msg'] = $message;

        return $this;
    }

    /**
     * Set recipient phone number.
     *
     * @param  string  $to
     */
    public function numbers(string $numbers): self
    {
        $this->payload['numbers'] = $numbers;

        return $this;
    }

    /**
     * Set sender name.
     *
     * @param  string  $from
     */
    public function sender(string $sender): self
    {
        $this->payload['userSender'] = $sender;

        return $this;
    }

    /**
     * Set notification delay.
     *
     * @param  string  $timestamp
     */
    public function delay(string $timestamp): self
    {
        $this->payload['dateTimeSendLater'] = $timestamp;

        return $this;
    }

    /**
     * Disable reload lock.
     */
    public function repeat(string $repeat = '0'): self
    {
        $this->payload['YesRepeat'] = $repeat;

        return $this;
    }

    /**
     * The API returns more details about the SMS sent.
     */
    public function by(): self
    {
        $this->payload['By'] = 'standard';

        return $this;
    }
}
