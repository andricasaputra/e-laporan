<?php

namespace App\Notifications;

interface NotificationsInterface
{
	public function __construct($message = null, $link = null);

	public function via($notifiable);

	public function toDatabase($notifiable);
}