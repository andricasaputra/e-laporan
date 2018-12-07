<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    public function indexEoffice()
    {
    	return redirect(route('login'));
    }
    
    public function indexEIkm()
    {
    	return redirect(route('ikm.home'));
    }

    public function login()
    {
    	return redirect(route('login'));
    }
}
