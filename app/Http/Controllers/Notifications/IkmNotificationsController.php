<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IkmNotificationsController extends MainNotificationController
{
    public function ikmApi($user_id)
    {
    	$user = User::find($user_id);

    	return $user->unreadNotifications()->where('type', 'App\Notifications\NewSurveyIkm')->get();
    }
}
