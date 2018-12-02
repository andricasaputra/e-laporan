<?php

namespace App\Listeners;

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
        foreach ($event->users as $user) {

            $user->notify(
               new $event->class_to_notify($event->message, $event->link)
            );

        }
    }
}
