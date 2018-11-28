<?php

namespace App\Listeners;

use App\Events\UpdatePegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAccountUpdate
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
    public function handle(UpdatePegawai $event)
    {
        $event->pegawai->user()->update([
            'username' => $event->request->username,
            'password' => Hash::make($event->request->password)
        ]);

        $user = $event->pegawai->user;

        /*update user role*/
        
        $user->role()->sync($event->request->role);

    }
}
