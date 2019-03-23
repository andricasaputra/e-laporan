<?php

namespace App\Listeners;

use App\Events\RegisterPegawai;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserProfile
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
        /*create user profile's*/
        $event->pegawai->profile()->create([

            'nama' => $event->request->nama
            
        ]);
    }
}
