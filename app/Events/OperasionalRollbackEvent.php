<?php

namespace App\Events;

use App\Models\Operasional\LogInfo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OperasionalRollbackEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Untuk menyimpan type (jenis permohonan) dari laporan yang di rollback
     *
     * @var string
     */
    public $type; 

    /**
     * Untuk menyimpan bulan dari laporan yang di rollback
     *
     * @var string
     */
    public $bulan;

    /**
     * Untuk menyimpan id wilker dari laporan yang di rollback
     *
     * @var int
     */
    public $wilkerId;

    /**
     * Create a new event instance.
     *
     * @param App\Models\Operasional\LogInfo $data
     * @return void
     */
    public function __construct(LogInfo $data)
    {
        // getRawOriginal () untuk meng ignore mutator
        // dari type dan bulan attributes
        // karna di model attribute bulan dan type
        // diubah formatnya
        $this->type     = $data->getRawOriginal ('type');

        $this->bulan    = $data->getRawOriginal ('bulan');
        
        $this->wilkerId = $data->wilker_id;
    }

}
