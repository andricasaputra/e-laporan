<?php

namespace App\Events;

use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Layanan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use App\Contracts\NotificationsEventInterface;
use Illuminate\Foundation\Events\Dispatchable;
use App\Notifications\IkmSurvey as Notifications;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewIkmSurveyEvent implements NotificationsEventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Untuk menyimpan users yang akan diberikan notifikasi
     *
     * @var \Illuminate\Support\Collection|mixed
     */
    public $users;

    /**
     * Untuk menyimpan periode survey yang diikuti
     *
     * @var string
     */
    public $periode;

     /**
     * Untuk menyimpan jenis survey layanan (KH/KT)
     *
     * @var string
     */
    public $jenis_layanan; 

     /**
     * Untuk menyimpan link yang akan dituju apabila 
     * pesan notifikasi di click
     *
     * @var string
     */
    public $link; 

    /**
     * Untuk menyimpan isi pesan notifikasi
     *
     * @var string
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param Illuminate\Support\Collection $user
     * @param string $periode
     * @param string $jenis_layanan
     * @param string $link
     * @return void
     */
    public function __construct($user, $periode, $jenis_layanan, $link)
    {
        $this->users            = $user;
        $this->periode          = Jadwal::whereId($periode)->first()->keterangan;
        $this->jenis_layanan    = Layanan::whereId($jenis_layanan)->first()->jenis_layanan;
        $this->link             = $link;
        $this->message          = "Seorang responden baru saja mengikuti survey {$this->periode} 
                                    untuk layanan {$this->jenis_layanan}";

        /*Fire main notification event*/
        event( new MainNotificationsEvent(new Notifications(), $this) );
    }

}
