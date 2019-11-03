<?php

namespace App\Listeners;

use App\Models\User;
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
        $user = User::wherePegawaiId($event->pegawai->id)->first();

        $user->update([

            'username' => $event->request->username,

            'password' => Hash::make($event->request->password)

        ]);

        /*update user wilker*/
        $user->wilker()->sync($event->request->wilker);

        /*update user role*/
        $user->role()->sync($event->request->role);

    }
}
