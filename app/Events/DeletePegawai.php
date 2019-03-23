<?php

namespace App\Events;

use App\Models\User;
use App\Models\MasterPegawai;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeletePegawai
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $pegawai;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, MasterPegawai $pegawai)
    {
        $this->user     = $user;
        $this->pegawai  = $pegawai;
    }
}
