<?php

namespace App\Listeners;

class NotificationSendingListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (method_exists($event->notification, 'dontSend')) {
            return !$event->notification->dontSend($event->notifiable);
        }

        return true;
    }
}
