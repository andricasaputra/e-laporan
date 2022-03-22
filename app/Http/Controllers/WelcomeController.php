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
    	return view('intern.welcome');
    }
}
