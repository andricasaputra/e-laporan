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

    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LogInfo $data)
    {
        $this->type     = $data->getOriginal('type');
        $this->bulan    = $data->getOriginal('bulan');
        $this->wilkerId = $data->wilker_id;
    }

}
