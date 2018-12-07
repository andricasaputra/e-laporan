<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ikm\Jadwal;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
    	$user 	= User::find(Auth::user()->id);
    	$ikm	= Jadwal::select('keterangan')->where('is_open', 1)->first();

    	return view('intern.welcome')->with(compact('user', 'ikm'));
    }
}
