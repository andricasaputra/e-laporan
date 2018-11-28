<?php

namespace App\Events;

use Illuminate\Http\Request;
use App\Models\MasterPegawai; 
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePegawai
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $pegawai;
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MasterPegawai $pegawai, Request $request)
    {
        $this->pegawai = $pegawai;
        $this->request = $request;
    }
}
