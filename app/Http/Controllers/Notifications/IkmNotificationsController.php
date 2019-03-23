<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class IkmNotificationsController extends MainNotificationController
{
	/**
     * Khusus menampilkan notifikasi dari IKM
     *
     * @param App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function ikmApi(User $user)
    {
    	return $user->unreadNotifications()
    				->whereType('App\Notifications\NewSurveyIkm')
    				->get();
    }
}
