<?php

namespace App\Notifications;

use App\CheckIn;
use App\RestArea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;
use App\Http\Resources\RestAreaItem as RestAreaResource;

class RestAreaReminder60 extends Notification implements ShouldQueue
{
    use Queueable;

    public $restArea;

    public $checkIn;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RestArea $restArea, CheckIn $checkIn)
    {
        $this->restArea = $restArea;

        $this->checkIn = $checkIn;

        $this->delay($checkIn->in->addMinutes(60));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->dontSend($notifiable)) {
            return [];
        }

        return [
            FcmChannel::class,
            'database',
        ];
    }

    public function dontSend($notifiable)
    {
        return !is_null($this->checkIn->out);
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
            ->title("[REST AREA] Waktu anda parkir sudah 60 menit")
            ->body("Ayo bijaksanalah dalam menggunakan waktumu, semua orang ingin istirahat.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "rest-area" => new RestAreaResource($this->restArea),
            "highway" => $this->restArea->highway,
            "duration" => 60,
        ];
    }
}
