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

class RegisterPegawai
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Untuk instance dari class MasterPegawai
     *
     * @var App\Models\MasterPegawai
     */
    public $pegawai;

    /**
     * Untuk instance dari class Request
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param App\Models\MasterPegawai $pegawai
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(MasterPegawai $pegawai, Request $request)
    {
        $this->pegawai = $pegawai;
        $this->request = $request;
    }
}
