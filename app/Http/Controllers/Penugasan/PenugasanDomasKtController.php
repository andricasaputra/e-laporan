<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenugasanDomasKtController extends Controller
{
    public function uploadPage()
    {
        return view('intern.penugasan.kt.upload.domas');
    }
}
