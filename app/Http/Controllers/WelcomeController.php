<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ikm\Jadwal;

class WelcomeController extends Controller
{
    public function __invoke()
    {
    	$user 	= auth()->user();

    	$ikm	= Jadwal::select('keterangan')->where('is_open', 1)->first();

    	return view('intern.welcome')->with(compact('user', 'ikm'));
    }
}
