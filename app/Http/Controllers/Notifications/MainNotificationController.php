<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ActiveUserTrait;
use App\Http\Controllers\Controller;

class MainNotificationController extends Controller
{
    use ActiveUserTrait;

    public function readNotifications(Request $request)
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
        ->with('notifications', $user->unreadNotifications);
    }

    public function mainApiNotifications(User $user_id)
    {
    	$user = User::find($user_id)->first();

    	return $user->unreadNotifications;
    }

    public function markAsReadAllNotifications(Request $request)
    {
        dd($request);
        $user = $this->activeUser();
        $user->unreadNotifications->markAsRead();

        return redirect(route('show.all.notifications'));
    }

    public function deleteNotifications(Request $request)
    {
        $user = $this->activeUser();

        $user->notifications()->delete();

        return redirect(route('show.all.notifications'))->with('success', 'Semua Pemberitahuan Berhasil Dihapus!');
    }
}
