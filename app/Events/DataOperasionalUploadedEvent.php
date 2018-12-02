<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Notifications\DataOperasionalUploaded as Notifications;

class DataOperasionalUploadedEvent implements NotificationsEventInterface
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

        event( new MainNotificationsEvent(new Notifications(), $this) );
    }

}
