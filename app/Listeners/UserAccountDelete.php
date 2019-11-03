<?php

namespace App\Listeners;

use App\Events\DeletePegawai;
use Illuminate\Support\Facades\Hash;
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
     * @param  UpdatePegawai  $event
     * @return void
     */
    public function handle(DeletePegawai $event)
    {
        /*delete user wilker*/
        $event->user->wilker()->detach();

        /*delete user role*/
        $event->user->role()->detach();

        /*delete user*/
        $event->user->destroy($event->user->id);

    }
}
