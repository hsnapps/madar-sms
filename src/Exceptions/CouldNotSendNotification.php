<?php

namespace NotificationChannels\Madar\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($message)
    {
        return new static('Madar Response: ' . $message);
    }

    public static function usernameNotProvided(): self
    {
        return new static('Username is missing.');
    }

    public static function passwordNotProvided(): self
    {
        return new static('Password is missing.');
    }

    public static function serviceNotAvailable($message): self
    {
        return new static($message);
    }

    public static function phoneNumberNotProvided(): self
    {
        return new static('No phone number was provided.');
    }
}
