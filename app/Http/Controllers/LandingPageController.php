<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    /**
     * Landing page untuk e-office (login)
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function indexEoffice()
    {
    	return redirect(route('login'));
    }
    
    /**
     * Landing page untuk web e-ikm
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function indexEIkm()
    {
    	return redirect(route('ikm.home'));
    }

    /**
     * Login redirect
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function login()
    {
    	return redirect(route('login'));
    }
}
