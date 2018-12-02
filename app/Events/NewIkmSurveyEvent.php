<?php

namespace App\Events;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Layanan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Notifications\IkmSurvey as Notifications;

class NewIkmSurveyEvent implements NotificationsEventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users, $periode, $jenis_layanan, $link, $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $periode, $jenis_layanan, $link)
    {
        $this->users            = $user;
        $this->periode          = Jadwal::whereId($periode)->first()->keterangan;
        $this->jenis_layanan    = Layanan::whereId($jenis_layanan)->first()->jenis_layanan;
        $this->link             = $link;
        $this->message          = "Seorang responden baru saja mengikuti survey {$this->periode} untuk layanan {$this->jenis_layanan}";

        event( new MainNotificationsEvent(new Notifications(), $this) );
    }

}
