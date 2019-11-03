<?php

namespace App\Http\Controllers;

use App\Models\Ikm\Jadwal;

class WelcomeController extends Controller
{
	/**
     * Menampilkan keterangan/status dari
     * semua aplikasi pada halaman "welcome"
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
    	$ikm  = Jadwal::select('keterangan')->whereIsOpen(1)->first();

    	return view('intern.welcome')->withIkm($ikm);
    }
}
