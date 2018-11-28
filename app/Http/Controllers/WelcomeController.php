<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
    	$user = User::find(Auth::user()->id);
    	return view('intern.welcome')->with('user', $user);
    }
}
