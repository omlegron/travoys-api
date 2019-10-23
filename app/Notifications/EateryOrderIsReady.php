<?php

namespace App\Notifications;

use App\EateryOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;

class EateryOrderIsReady extends Notification
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
            ->title("Pesanan siap diambil!")
            ->body("Yay! Pesanan kamu sudah selesai nih, silakan ambil di petugas kami.");
    }
}
