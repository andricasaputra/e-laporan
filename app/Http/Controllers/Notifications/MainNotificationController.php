<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainNotificationController extends Controller
{
    /**
     * Untuk membaca single notifications
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function readNotifications(Request $request)
    {
        auth()->user()->notifications
                      ->where('id', $request->id)
                      ->where('notifiable_id', $request->notifiable_id)
                      ->markAsRead();

        return redirect($request->redirect);
    }

    /**
     * Untuk melihat semua notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllNotifications()
    {
        return view('intern.notifications.allnotifications')
                    ->withUser(auth()->user())
                    ->withNotifications(auth()->user()->notifications()->paginate(10));
    }

    /**
     * Untuk melihat notifications pada icon notifikasi
     *
     * @return \Illuminate\Http\Response
     */
    public function mapNotifications()
    {
        return view('intern.notifications.mapnotifications')
                    ->withUser(auth()->user())
                    ->withNotifications(auth()->user()->unreadNotifications->take(50));
    }

    /**
     * Resource dari semua notifikasi yang belum terbaca
     *
<<<<<<< HEAD
     * @param App\Models\User $user
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function mainApiNotifications(User $user)
    {
    	return $user->unreadNotifications;
    }

    /**
     * Untuk marked semua notifikasi apabila tombol
     * "tandai baca semua ditekan"
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function markAsReadAllNotifications(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect(route('show.all.notifications'));
    }

    /**
     * Untuk menghapus semua notifikasi apabila tombol
     * "hapus semua notifikasi ditekan"
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     * @return \Illuminate\Http\Response
     */
    public function deleteNotifications(Request $request)
    {
        auth()->user()->notifications()->delete();

        return redirect(route('show.all.notifications'))
                ->withSuccess('Semua Pemberitahuan Berhasil Dihapus!');
    }
}
