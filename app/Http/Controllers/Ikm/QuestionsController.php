<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Answer as Jawaban;
use App\Models\Ikm\Question as Pertanyaan;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Pertanyaan::all();

        return view('intern.ikm.question.index')
                ->with('questions', $question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $answers = Jawaban::all();
        
        return view('intern.ikm.question.create')->with('answers', $answers);
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

            'pertanyaan' => 'required|min:10',
            'jawaban_1' => 'required',
            'jawaban_2' => 'required',
            'jawaban_3' => 'required',
            'jawaban_4' => 'required',

        ]);

        $question = Pertanyaan::create([

            'question' => $request->pertanyaan

        ]);

        $question->answer()->attach([
            $request->jawaban_1,
            $request->jawaban_2,
            $request->jawaban_3,
            $request->jawaban_4
        ]);

        return redirect(route('intern.ikm.question.index'))
                ->with('success', 'Berhasil Tambah pertanyaan!');
    }

    public function show(Pertanyaan $question)
    {
        return view('intern.ikm.question.show')
                ->with('question', $question)
                ->with('answers', $question->answer()->orderBy('nilai', 'asc')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pertanyaan $question)
    {
        $answers = Jawaban::all();

        return view('intern.ikm.question.edit')
                ->with('question', $question)
                ->with('answers', $answers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pertanyaan $question)
    {
        $question->question = $request->pertanyaan;

        $question->save();

        $question->answer()->sync([
            $request->jawaban_1,
            $request->jawaban_2,
            $request->jawaban_3,
            $request->jawaban_4
        ]);

        return redirect(route('intern.ikm.question.index'))
                ->with('success', 'Berhasil Tambah pertanyaan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertanyaan $question)
    {
        $question->answer()->detach();

        $question->delete();

        return redirect(route('intern.ikm.question.index'))
                ->with('success', 'Data Berhasil Dihapus!');
    }
}
