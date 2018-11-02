<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ikm\Question;
use App\Models\Ikm\Layanan;
use App\Models\Ikm\Umur;
use App\Models\Ikm\Pendidikan;
use App\Models\Ikm\Pekerjaan;

class SurveyPage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question   = Question::with('answer')->get();
        $layanan    = Layanan::all();
        $umur       = Umur::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan  = Pekerjaan::all();

        return view('ikm.survey')
        ->with('questions', $question)
        ->with('layanan', $layanan)
        ->with('umur', $umur)
        ->with('pendidikan', $pendidikan)
        ->with('pekerjaan', $pekerjaan);
    }
}
