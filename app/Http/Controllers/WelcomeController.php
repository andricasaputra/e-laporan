<?php

namespace App\Http\Controllers;

use App\Models\Ikm\Jadwal;

class WelcomeController extends Controller
{
    public function __invoke()
    {
    	$user 	= auth()->user();

    	$ikm	= Jadwal::select('keterangan')->whereIsOpen(1)->first();

    	return view('intern.welcome')->with(compact('user', 'ikm'));
    }
}
