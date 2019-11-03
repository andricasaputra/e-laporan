<?php

namespace App\Http\Controllers;

use App\Models\Ikm\Jadwal;

class WelcomeController extends Controller
{
<<<<<<< HEAD
	/**
     * Menampilkan keterangan/status dari
     * semua aplikasi pada halaman "welcome"
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
    	$user = auth()->user();

    	$ikm  = Jadwal::select('keterangan')->whereIsOpen(1)->first();
=======
    public function __invoke()
    {
    	$user 	= auth()->user();

    	$ikm	= Jadwal::select('keterangan')->whereIsOpen(1)->first();
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

    	return view('intern.welcome')->with(compact('user', 'ikm'));
    }
}
