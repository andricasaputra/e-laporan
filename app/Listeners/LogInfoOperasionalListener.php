<?php

namespace App\Listeners;

use App\Models\Wilker;
use App\Models\Operasional\LogInfo;
use App\Events\LogInfoOperasionalEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogInfoOperasionalListener
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
     * @param  LogInfoOperasionalEvent  $event
     * @return void
     */
    public function handle(LogInfoOperasionalEvent $event)
    {
        $namaWilker = $event->wilker->getOriginal('nama_wilker');

        $wilker     = Wilker::whereNamaWilker($namaWilker)->first();

        LogInfo::create([

            'type' => $event->table,
            'bulan' => $event->tanggal,
            'wilker_id' => $wilker->id

        ]);
    }
}
