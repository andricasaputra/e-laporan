<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LogInfoOperasionalEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Untuk menyimpan nama tabel yang dikirim
     *
     * @var string
     */
    public $table;

    /**
     * Untuk menyimpan nama wilker
     *
     * @var string
     */
    public $wilker;

    /**
     * Untuk menyimpan tanggal laporan
     *
     * @var string
     */
    public $tanggal;

    /**
     * Create a new event instance.
     *
     * @param App\Events\DataOperasionalUploadedEvent $data
     * @return void
     */
    public function __construct(DataOperasionalUploadedEvent $data)
    {
        $this->table    = $data->table;
        $this->wilker   = $data->wilker;
        $this->tanggal  = $data->tanggal;
    }

}
