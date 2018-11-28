<?php

namespace App\Events;

use App\Models\MasterPegawai; 
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RegisterPegawai
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pegawai;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MasterPegawai $pegawai, array $data)
    {
        $this->pegawai = $pegawai;
        $this->data = $data;
    }
}
