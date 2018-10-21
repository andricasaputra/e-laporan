<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('kh');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kh.home');
    }
}
