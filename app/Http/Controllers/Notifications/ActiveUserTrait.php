<?php

namespace App\Http\Controllers\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait ActiveUserTrait
{
	public function index()
    {
    	$user = $this->activeUser();

    	return view('intern.welcome')->with('user', $user);
    }

    public function activeUser()
    {
        return User::find(Auth::user()->id);
    }
}