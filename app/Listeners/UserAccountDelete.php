<?php

namespace App\Listeners;

use App\Events\DeletePegawai;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAccountDelete
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
     * @param  DeletePegawai  $event
     * @return void
     */
    public function handle(DeletePegawai $event)
    {
        /*delete user role*/
        $event->user->role()->detach();

        /*delete user account login*/
        $event->user->delete();
    }
}
