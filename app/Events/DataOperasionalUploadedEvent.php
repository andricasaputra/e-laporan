<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use App\Contracts\NotificationsEventInterface;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Notifications\DataOperasionalUploaded as Notifications;
use App\Http\Controllers\Operasional\UploadOperasionalController as Upload;

class DataOperasionalUploadedEvent implements NotificationsEventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $wilker, $message, $users, $tanggal, $link, $table;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->tanggal  = $data->tanggal;
        $this->wilker   = $data->wilker;
        $this->users    = $data->usersToNotify;
        $this->message  = $data->notifyMessage;
        $this->link     = $data->linkNotify;
        $this->table    = $data->table;

        event( new LogInfoOperasionalEvent($this) );

        event( new MainNotificationsEvent(new Notifications(), $this) );
    }

}
