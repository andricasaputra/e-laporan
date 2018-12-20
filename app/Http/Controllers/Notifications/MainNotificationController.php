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
        $this->activeUser()->notifications->where('id', $request->id)
                           ->where('notifiable_id', $request->notifiable_id)
                           ->first()
                           ->markAsRead();

        return redirect($request->redirect);
    }

    public function showAllNotifications()
    {
        return view('intern.notifications')
                    ->with('user', $this->activeUser())
                    ->with('notifications', $this->activeUser()->notifications()->paginate(10));
    }

    public function mapNotifications()
    {
        return view('intern.mapnotifications')
                    ->with('user', $this->activeUser())
                    ->with('notifications', $this->activeUser()->unreadNotifications);
    }

    public function mainApiNotifications(User $user)
    {
    	return $user->unreadNotifications;
    }

    public function markAsReadAllNotifications(Request $request)
    {
        $this->activeUser()->unreadNotifications->markAsRead();

        return redirect(route('show.all.notifications'));
    }

    public function deleteNotifications(Request $request)
    {
        $this->activeUser()->notifications()->delete();

        return redirect(route('show.all.notifications'))
                ->with('success', 'Semua Pemberitahuan Berhasil Dihapus!');
    }
}
