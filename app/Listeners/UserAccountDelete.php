<?php

namespace App\Listeners;

use App\Events\DeletePegawai;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @param  UpdatePegawai  $event
=======
     * @param  DeletePegawai  $event
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return void
     */
    public function handle(DeletePegawai $event)
    {
        /*delete user wilker*/
        $event->user->wilker()->detach();

        /*delete user role*/
        $event->user->role()->detach();

<<<<<<< HEAD
        /*delete user*/
        $event->user->destroy($event->user->id);

=======
        /*delete user account login*/
        $event->user->delete();
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}
