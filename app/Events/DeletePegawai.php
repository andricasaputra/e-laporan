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

    /**
     * Untuk instance dari class User
     *
     * @var App\Models\User
     */
    public $user;

    /**
     * Untuk instance dari class MasterPegawai
     *
     * @var App\Models\MasterPegawai
     */
    public $pegawai;

    /**
     * Create a new event instance.
     *
     * @param App\Models\User $user
     * @param App\Models\MasterPegawai $pegawai
     * @return void
     */
    public function __construct(User $user, MasterPegawai $pegawai)
    {
        $this->user     = $user;
        $this->pegawai  = $pegawai;
    }
}
