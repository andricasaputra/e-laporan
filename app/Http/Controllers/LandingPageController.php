<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    /**
     * Landing page untuk e-office (login)
     *
     * @return void
     */
    public function indexEoffice()
    {
    	return redirect(route('login'));
    }
    
    /**
     * Landing page untuk web e-ikm
     *
     * @return void
     */
    public function indexEIkm()
    {
    	return redirect(route('ikm.home'));
    }

    /**
     * Login redirect
     *
     * @return void
     */
    public function login()
    {
    	return redirect(route('login'));
    }
}
