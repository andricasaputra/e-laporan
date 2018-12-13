<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Answer as Jawaban;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $answers = Jawaban::all();

        return view('intern.ikm.answer.index')->with(compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.answer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'answer' => 'required|min:4|max:30',
            'nilai' => 'required'

        ]);

        $answer = new Jawaban;

        $answer->answer = $request->answer;

        $answer->save();

        return redirect(route('intern.ikm.answer.index'))
                ->with('success', 'Berhasil Tambah Jawaban!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Jawaban $answer)
    {
        return view('intern.ikm.answer.edit')->with('answer', $answer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jawaban $answer)
    {
        $request->validate([

            'jawaban' => 'required|min:4|max:20',
            'nilai' => 'required'

        ]);

        $answer->answer = $request->jawaban;

        $answer->save();

        return redirect(route('intern.ikm.answer.index'))
                ->with('success', 'Berhasil Ubah Jawaban!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jawaban $answer)
    {
        $answer->delete();

        return redirect(route('intern.ikm.answer.index'))
                ->with('success', 'Data Berhasil Dihapus!');
    }
}
