<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DataOperasionalUploadedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $wilker, $message, $users, $tanggal, $link;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($users, $wilker, $tanggal, $message, $link)
    {
        $this->tanggal  = $tanggal;
        $this->wilker   = $wilker;
        $this->users    = $users;
        $this->message  = $message;
        $this->link     = $link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['laporan-uploaded'];
    }

    public function broadcastAs() 
    {
        return 'laporan-bulanan';
    }
}
