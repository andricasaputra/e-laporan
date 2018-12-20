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
        $wilker = Wilker::where('nama_wilker', $event->wilker->nama_wilker)
                    ->first();

        LogInfo::create([

            'type' => $event->table,
            'bulan' => $event->tanggal,
            'wilker_id' => $wilker->id

        ]);
    }
}
