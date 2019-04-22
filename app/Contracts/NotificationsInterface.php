<?php

namespace App\Contracts;

interface NotificationsInterface
{
     /**
     * Create a new notification instance.
     *
     * @param string|null $message
     * @param string|null $link
     * @return void
     */
	public function __construct($message = null, $link = null);

	/**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
	public function via($notifiable);

	/**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
	public function toDatabase($notifiable);
}