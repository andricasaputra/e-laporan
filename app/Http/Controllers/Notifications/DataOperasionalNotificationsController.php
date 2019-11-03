<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class DataOperasionalNotificationsController extends MainNotificationController
{
	/**
     * Khusus menampilkan notifikasi dari Operasional
     *
<<<<<<< HEAD
     * @param App\Models\User $user
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function operasionalApi(User $user)
    {
    	return $user->unreadNotifications()
    				->whereType('App\Notifications\DataOperasionalUploaded')
    				->get();
    }
}
