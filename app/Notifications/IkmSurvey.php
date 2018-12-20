<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Contracts\NotificationsInterface;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IkmSurvey extends Notification implements ShouldQueue, NotificationsInterface
{
    use Queueable;

    public $message, $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message = null, $link = null)
    {
        $this->message  = $message;
        $this->link     = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [

            'message' => $this->message, 
            'link' => $this->link, 
            'type' => 'E-IKM'
            
        ];
    }
}
