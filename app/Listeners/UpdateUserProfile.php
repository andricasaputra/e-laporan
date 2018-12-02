<?php

namespace App\Listeners;

use App\Events\UpdatePegawai;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserProfile
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
        /*update user profile's*/
        $event->pegawai->profile()->update([
            'nama' => $event->request->nama
        ]);
    }
}
