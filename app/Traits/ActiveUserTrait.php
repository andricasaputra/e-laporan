<?php

namespace App\Traits;

use App\Models\User;

trait ActiveUserTrait
{
	public function index()
    {
    	return view('intern.welcome')
    			->with('user', $this->activeUser());
    }

    public function activeUser()
    {
        return User::find(auth()->user()->id);
    }
}