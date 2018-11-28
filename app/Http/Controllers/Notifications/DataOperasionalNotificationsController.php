<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DataOperasionalNotificationsController extends Controller
{
    public function index()
    {
    	$user = $this->activeUser();;
    	return view('intern.welcome')->with('user', $user);
    }

    public function operasionalApi($user_id)
    {
    	$user = User::find($user_id);
    	return $user->unreadNotifications;
    }

    public function notifications(Request $request)
    {
        $user = $this->activeUser();
        $user->notifications->where('id', $request->id)->where('notifiable_id', $request->notifiable_id)
        ->first()->markAsRead();

        return redirect($request->redirect);
    }

    public function showAllNotifications()
    {
        $user = $this->activeUser();
        return view('intern.notifications')
        ->with('user', $user)
        ->with('notifications', $user->notifications()->paginate(10));
    }

    public function mapNotifications()
    {
        $user = $this->activeUser();
        return view('intern.mapnotifications')->with('user', $user)
        ->with('notifications', $user->unreadNotifications()->take(5)->get());
    }

    public function activeUser()
    {
        $user = User::find(Auth::user()->id);

        return $user;
    }
}
