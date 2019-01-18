<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class DataOperasionalNotificationsController extends MainNotificationController
{
    public function operasionalApi($user_id)
    {
    	$user = User::find($user_id);

    	return $user->unreadNotifications()
    				->whereType('App\Notifications\DataOperasionalUploaded')
    				->get();
    }
}
