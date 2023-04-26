<?php

namespace NotificationChannels\Madar;

use NotificationChannels\Madar\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class MadarChannel
{
    /**
     * @var Madar
     */
    protected $madar;

    /**
     * @param  Madar  $madar
     */
    public function __construct(Madar $madar)
    {
        $this->madar = $madar;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Madar\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMadarSms($notifiable);

        // No MadarMessage object was returned
        if (is_string($message)) {
            $message = MadarMessage::create($message);
        }

        if (!$message->hasToNumber()) {
            if (!$numbers = $notifiable->phone_number) {
                $numbers = $notifiable->routeNotificationFor('sms');
            }

            if (!$numbers) {
                throw CouldNotSendNotification::phoneNumberNotProvided();
            }

            $message->numbers($numbers);
        }

        $params = $message->toArray();

        if ($message instanceof MadarMessage) {
            $response = $this->madar->sendMessage($params);
        } else {
            return;
        }

        return __('response.' . $response->getBody()->getContents());
    }
}
