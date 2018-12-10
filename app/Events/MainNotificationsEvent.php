<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Events\NotificationsEventInterface; /*This is the event to call notification*/
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use App\Notifications\NotificationsInterface;/*This is the notification*/
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MainNotificationsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $classToNotify, $message, $users, $link;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotificationsInterface $classToNotify, NotificationsEventInterface $notifications)
    {
        $this->classToNotify = $classToNotify;
        $this->users         = $notifications->users;
        $this->message       = $notifications->message;
        $this->link          = $notifications->link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['all-notifiactions'];
    }

    public function broadcastAs() 
    {
        return 'all-notifications-report';
    }
}
