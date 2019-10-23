<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;

class YukMampirOnCheckedIn extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            FcmChannel::class
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
            ->title("Yuk Mampir!")
            ->body("Yuk Mampir ke destinasi menarik di luar jalan tol yang terdekat dari lokasi mu saat ini !");
    }
}
