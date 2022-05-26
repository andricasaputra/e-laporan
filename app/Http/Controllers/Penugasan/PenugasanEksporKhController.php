<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenugasanEksporKhController extends Controller
{
    public function uploadPage()
    {
        return view('intern.penugasan.kh.upload.ekspor');
    }
}
