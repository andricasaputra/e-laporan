<?php

namespace App\Listeners;

use App\Events\RegisterPegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAccountRegister
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
     * @param  RegisterPegawai  $event
     * @return void
     */
    public function handle(RegisterPegawai $event)
    {
        $user = $event->pegawai->user()->create([

            'username' => $event->request->username,
            'password' => Hash::make($event->request->password)
            
        ]);

        /*insert new user wilker*/
        $user->wilker()->attach($event->request->wilker);

        /*insert new user role*/
        $user->role()->attach($event->request->role);
    }
}
