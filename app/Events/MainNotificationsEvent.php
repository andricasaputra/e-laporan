<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Contracts\NotificationsEventInterface as Event;
use App\Contracts\NotificationsInterface as Notification;

class MainNotificationsEvent /*implements ShouldBroadcast*/
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Untuk instance dari class yang mengimplementasikan
     * class App\Contracts\NotificationsInterface;
     *
     * @var App\Notifications\DataOperasionalUploaded |
     *      App\Notifications\IkmSurvey |
     *      App\Notifications\UpdateAplikasiNotification |
     */
    public $classToNotify;

    /**
     * Untuk menyimpan isi pesan notifikasi
     *
     * @var string
     */
    public $message;

    /**
     * Untuk menyimpan users yang akan diberikan notifikasi
     *
     * @var \Illuminate\Support\Collection|mixed
     */
    public $users; 

    /**
     * Untuk menyimpan link yang akan dituju apabila 
     * pesan notifikasi di click
     *
     * @var string
     */
    public $link;

    /**
     * Create a new event instance.
     *
     * @param App\Contracts\NotificationsInterface $classToNotify (delegated class in notifications folder)
     * @param App\Contracts\NotificationsEventInterface $notification (data attributes)
     * @return void
     */
    public function __construct(Notification $classToNotify, Event $notificationsData)
    {
        $this->classToNotify = $classToNotify;
        $this->users         = $notificationsData->users;
        $this->message       = $notificationsData->message;
        $this->link          = $notificationsData->link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    /**
    * The Errors  Note!!
    *
    * @return  Illuminate \ Broadcasting \ BroadcastException
    * The data content of this event exceeds the allowed maximum (10240 bytes). 
    * See http://pusher.com/docs/server_api_guide/server_publishing_events for more info
    *
    */
    /*public function broadcastOn()
    {
        return ['all-notifiactions'];
    }

    public function broadcastAs() 
    {
        return 'all-notifications-report';
    }*/
}
