<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use App\Models\Ikm\Umur;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Layanan;
use Illuminate\Http\Request;
use App\Models\Ikm\Question;
use App\Models\Ikm\Pekerjaan;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Pendidikan;
use App\Http\Controllers\Controller;

class SurveyPage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $is_open    = Jadwal::where('is_open', 1)->where('is_open', '!=', NULL)->first();
        $questions  = Question::with('answer')->get();
        $layanan    = Layanan::all();
        $umur       = Umur::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan  = Pekerjaan::all();

        return view('ikm.survey')
        ->with(compact(
            'is_open', 
            'questions',
            'layanan',
            'umur',
            'pendidikan',
            'pekerjaan'
        ));  
    }

    public function store(Request $request)
    {
        $request->validate([

            'jenis_layanan' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'jenis_layanan' => 'required',

        ]);

        $responden = Responden::create([

            'ikm_id' => $request->ikm_id,
            'layanan_id' => $request->jenis_layanan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur_id' => $request->umur,
            'pendidikan_id' => $request->pendidikan,
            'pekerjaan_id' => $request->pekerjaan,

        ]);

        $answer = $request->except([
            'ikm_id',
            'jenis_layanan',
            'jenis_kelamin',
            'umur',
            'pendidikan',
            'pekerjaan',
            '_token'
        ]);

        foreach ($answer as $key => $value) {

            $responden->result()->create([

                'ikm_id' => $request->ikm_id,
                'responden_id' => $responden->id,
                'question_id' => $key,
                'answer_id' => $value[0]

            ]);
            
        }

        return route('ikm.success', $responden->id);
    }

    public function success(int $id)
    {
        $responden = Responden::find($id);

        if ($responden === null) {
           return abort(404);
        }

        return view('ikm.success')
        ->with('responden', $responden);
    }

    public function cetak(int $id)
    {
        $responden          = Responden::find($id);

        if ($responden === null) {
           return abort(404);
        }

        $answers            = $responden->answer;
        $question_answer    = Question::with('question_answer')->get();

        return view('ikm.cetak')
        ->with('responden', $responden)
        ->with('answers', $answers)
        ->with('question_answer', $question_answer);
    }
}
