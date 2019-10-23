<?php

namespace App\Notifications;

use App\EateryOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;

class EateryOrderCreated extends Notification
{
    use Queueable;

    public $eateryOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EateryOrder $eateryOrder)
    {
        $this->eateryOrder = $eateryOrder;
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
            ->title("Ada Pesanan Baru!")
            ->body("{$this->eateryOrder->code}");
    }
}
