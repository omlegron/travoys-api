<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;

class CustomFcmNotification extends Notification
{
    use Queueable;

    public $title;

    public $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $title, string $body)
    {
        $this->title = $title;

        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            FcmChannel::class,
        ];
    }

    /**
     * Get the FCM representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Edujugon\PushNotification\Messages\PushMessage
     */
    public function toFcm($notifiable)
    {
        return (new PushMessage())
            ->title($this->title)
            ->body($this->body);
    }
}
