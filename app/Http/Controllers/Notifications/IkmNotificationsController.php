<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class IkmNotificationsController extends MainNotificationController
{
	/**
     * Khusus menampilkan notifikasi dari IKM
     *
<<<<<<< HEAD
     * @param App\Models\User $user
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function ikmApi(User $user)
    {
    	return $user->unreadNotifications()
    				->whereType('App\Notifications\NewSurveyIkm')
    				->get();
    }
}
