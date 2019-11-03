<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    /**
     * Landing page untuk e-office (login)
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEoffice()
    {
    	return redirect(route('login'));
    }
    
    /**
     * Landing page untuk web e-ikm
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEIkm()
    {
    	return redirect(route('ikm.home'));
    }

    /**
     * Login redirect
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
    	return redirect(route('login'));
    }
}
