<?php

namespace App\Http\Controllers\Operasional\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeAdminController extends Controller
{
    public function index()
    {
    	return view('intern.operasional.admin.home');
    } 
}
