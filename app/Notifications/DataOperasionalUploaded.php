<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DataOperasionalUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    public $wilker, $tanggal, $message, $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($wilker, $tanggal, $message, $link)
    {
        $this->wilker   = $wilker;
        $this->tanggal  = $tanggal;
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

            'wilker' => $this->wilker,
            'tanggal' => $this->tanggal,
            'message' => $this->message, 
            'link' => $this->link, 
        ];
    }

}
