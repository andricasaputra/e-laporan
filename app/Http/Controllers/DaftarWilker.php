<?php

namespace App\Http\Controllers;

use App\Models\Wilker;
use Illuminate\Http\Request;

class DaftarWilker extends Controller
{
   public function index()
   {
   		$wilker = Wilker::all();
   		return view('auth.register')->with('wilker', $wilker);
   }
}
