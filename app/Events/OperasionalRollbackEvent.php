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

    public $type, $bulan, $wilkerId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LogInfo $data)
    {
<<<<<<< HEAD
        // getOriginal() untuk meng ignore mutator
        // dari type dan bulan attributes
        $this->type     = $data->getOriginal('type');

        $this->bulan    = $data->getOriginal('bulan');
        
=======
        $this->type     = $data->getOriginal('type');
        $this->bulan    = $data->getOriginal('bulan');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        $this->wilkerId = $data->wilker_id;
    }

}
