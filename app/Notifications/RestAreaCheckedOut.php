<?php

namespace App\Notifications;

use App\RestArea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Edujugon\PushNotification\Channels\FcmChannel;
use Edujugon\PushNotification\Messages\PushMessage;
use App\Http\Resources\RestAreaItem as RestAreaResource;

class RestAreaCheckedOut extends Notification
{
    use Queueable;

    public $restArea;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RestArea $restArea)
    {
        $this->restArea = $restArea;
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
            'database',
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
            ->title("[REST AREA] Waktu anda parkir sudah berhenti")
            ->body("Udah istirahat kan? Terima kasih ya udah berkunjung ke Rest Area {$this->restArea->name}! Hati-hati di jalan!.");
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
        ];
    }
}
