<?php

namespace App\Listeners;

use App\Events\DataOperasionalUploadedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\DataOperasionalUploaded;

class DataOperasionalUploadedListener
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
     * @param  DataOperasionalUploadedEVent  $event
     * @return void
     */
    public function handle(DataOperasionalUploadedEvent $event)
    {
        foreach ($event->users as $user) {

            $user->notify(new DataOperasionalUploaded($event->wilker, $event->tanggal, $event->message, $event->link));
        }
    }
}
