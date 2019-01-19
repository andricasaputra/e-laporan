<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainNotificationController extends Controller
{
    public function readNotifications(Request $request)
    {
        auth()->user()->notifications
                      ->where('id', $request->id)
                      ->where('notifiable_id', $request->notifiable_id)
                      ->markAsRead();

        return redirect($request->redirect);
    }

    public function showAllNotifications()
    {
        return view('intern.notifications')
                    ->withUser(auth()->user())
                    ->withNotifications(auth()->user()->notifications()->paginate(10));
    }

    public function mapNotifications()
    {
        return view('intern.mapnotifications')
                    ->withUser(auth()->user())
                    ->withNotifications(auth()->user()->unreadNotifications);
    }

    public function mainApiNotifications(User $user)
    {
    	return $user->unreadNotifications;
    }

    public function markAsReadAllNotifications(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect(route('show.all.notifications'));
    }

    public function deleteNotifications(Request $request)
    {
        auth()->user()->notifications()->delete();

        return redirect(route('show.all.notifications'))
                ->withSuccess('Semua Pemberitahuan Berhasil Dihapus!');
    }
}
