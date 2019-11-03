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

<<<<<<< HEAD
    /**
     * Untuk menyimpan wilker dan digunakan sebagai notifikasi 
     *
     * @var array|collections 
     */
    public $wilker; 

    /**
     * Untuk menyimpan pesan notifikasi
     *
     * @var string 
     */
    public $message; 

    /**
     * Untuk menyimpan users yang akan mendapatkan notifikasi
     *
     * @var string 
     */
    public $users; 

    /**
     * Untuk menyimpan tanggal dari laporan
     *
     * @var string 
     */
    public $tanggal;

    /**
     * Untuk menyimpan link dari notifikasi
     *
     * @var string 
     */ 
    public $link; 

    /**
     * Untuk menyimpan nama tabel model yang 
     * mempunyai notifikasi
     *
     * @var string 
     */
    public $table;
=======
    public $wilker, $message, $users, $tanggal, $link, $table;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

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

        /*Fire log operasional event*/
        event( new LogInfoOperasionalEvent($this) );

        /*Fire main notifications event*/
        event( new MainNotificationsEvent(new Notifications(), $this) );
    }

}
