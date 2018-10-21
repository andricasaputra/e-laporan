<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DaftarWilker as Wilker;

class DaftarWilker extends Controller
{
   public function index()
   {
   		$wilker = Wilker::all();
   		return view('auth.register')->with('wilker', $wilker);
   }
}
