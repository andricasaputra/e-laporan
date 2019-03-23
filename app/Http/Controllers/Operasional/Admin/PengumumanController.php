<?php

namespace App\Http\Controllers\Operasional\Admin;

use Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UpdateAplikasiEvent;
use App\Http\Controllers\Controller;
use App\Models\Operasional\Admin\Pengumuman;
use App\Notifications\UpdateAplikasiNotification;

class PengumumanController extends Controller
{
    public $link;
    public $message;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('intern.operasional.admin.pengumuman.index')
                ->withPengumuman(Pengumuman::all());
    }

    /**
     * Show menu page
     *
     * @return \Illuminate\Http\Response
     */
    public function menu()
    {
        return view('intern.operasional.admin.pengumuman.create.menu');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.operasional.admin.pengumuman.create.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'konten' => 'required'

        ]);

        foreach ($request->konten as $key => $value) {
            
            Pengumuman::create([

                'user_id' => $request->user_id,
                'konten' => ltrim($value),
                'show' => 1

            ]);

        }

        if ($request->has('notify')) $this->setNotification();
        
        return back()->withSuccess('Berhasil tambah pengumuman');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pengumuman $pengumuman)
    {
        $pengumuman->update([

            'user_id' => $pengumuman->user_id,
            'konten' => $pengumuman->konten,
            'show' => $pengumuman->show == 'Sedang ditampilkan' ? 2 : 1,

        ]);

        return redirect(route('admin.pengumuman.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('intern.operasional.admin.pengumuman.create.edit')
                ->withPengumuman($pengumuman);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([

            'konten' => 'required'

        ]);

        foreach ($request->konten as $key => $value) {
            
            $pengumuman->update([

                'user_id' => $request->user_id,
                'konten' => ltrim($value),
                'show' => 1

            ]);

        }

        return redirect(route('admin.pengumuman.index'))
                ->withSuccess('Berhasil tambah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect(route('admin.pengumuman.index'))
                ->withSuccess('Berhasil tambah dihapus');
    }

    /**
     * Show info page for user
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        return view('intern.operasional.info')
                ->withPengumumans(Pengumuman::active());
    }

    public function setNotification()
    {
        $this->link     = route('page.info');
        $this->message  = 'Klik disini untuk melihat informasi terbaru tentang update aplikasi E-Operasional';

        $users = User::where('id', '!=', auth()->user()->id)->get();

        Notification::send($users, new UpdateAplikasiNotification($this));
    }
}
