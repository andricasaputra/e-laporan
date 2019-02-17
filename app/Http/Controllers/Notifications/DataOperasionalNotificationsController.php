<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class DataOperasionalNotificationsController extends MainNotificationController
{
	/**
     * Khusus menampilkan notifikasi dari Operasional
     *
     * @return \Illuminate\Http\Response
     */
    public function operasionalApi(User $user)
    {
    	return $user->unreadNotifications()
    				->whereType('App\Notifications\DataOperasionalUploaded')
    				->get();
    }
}
