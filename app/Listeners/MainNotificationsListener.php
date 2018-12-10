<?php

namespace App\Listeners;

use Notification;
use App\Events\MainNotificationsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MainNotificationsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MainNotificationsEvent  $event
     * @return void
     */
    public function handle(MainNotificationsEvent $event)
    {
        Notification::send(
            $event->users, new $event->classToNotify($event->message, $event->link)
        );
    }
}
