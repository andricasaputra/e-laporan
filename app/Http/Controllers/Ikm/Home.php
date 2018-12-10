<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Ikm;

use DataTables;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Answer;
use App\Models\Ikm\Result;
use App\Models\Ikm\Question;
use Illuminate\Http\Request;
use App\Models\Ikm\Responden;
use App\Http\Controllers\Controller;

class Home extends Controller
{
    public function api(int $ikmId = null)
    {
        $ikmId = $ikmId ?? 1;

        $responden  =   Responden::with([
                            'layanan', 'umur', 'pekerjaan', 'pendidikan', 'ikm','answer'
                        ])->where('ikm_id', $ikmId)->orderBy('created_at', 'desc')->get();

        return  Datatables::of($responden)->addIndexColumn()
                ->addColumn('action', function ($responden) use ($ikmId) {

                    return '<a href="'.route('intern.ikm.home.edit', $responden->id).'" class="btn btn-xs btn-primary">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                            <a href="'.route('intern.ikm.home.show', [$responden->id, $ikmId]).'" class="btn btn-xs btn-success">
                                <i class="glyphicon glyphicon-eye-open"></i> Detail
                            </a>
                            <a href="#" data-id = "'.$responden->id.'"  class="btn btn-danger btn-xs" id="deleteIkm">
                                <i class="glyphicon glyphicon-trash"></i> Delete
                            </a>';

                })->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailApi(int $id, int $ikmId)
    {
        $result =   Result::with([
                        'responden', 'question', 'answer', 'ikm'
                    ])->whereIn('responden_id', [$id])->where('ikm_id', $ikmId)->get();

        return Datatables::of($result)->addIndexColumn()->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $ikmId = null)
    {
        $ikmId  = $ikmId ?? $this->setIkmId();

        $ikm    = Jadwal::select('id', 'keterangan')->get();

        return view('intern.ikm.home.index')->with(compact(['ikmId', 'ikm']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Responden $responden, int $year)
    {
        return view('intern.ikm.home.show')->with(compact('responden'))
                ->with(compact('year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Responden $responden)
    {
        $answers            = $responden->answer;
        $question_answer    = Question::with('question_answer')->get();

        return view('intern.ikm.home.edit')
                ->with('responden', $responden)
                ->with('answers', $answers)
                ->with('question_answer', $question_answer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responden $responden)
    {
        $answer =   $request->except([
                        'responden_id','submit','_method','_token',
                    ]);

        $no = 0;

        for ($i = 0; $i < count($answer[$responden->id]); $i++) { 

            $result = Result::where('responden_id', $responden->id)
                        ->where('answer_id', $responden->result[$i]->answer_id)->first();

            $result->answer_id = $answer[$responden->id][$i];

            $result->save();

        }

        return redirect(route('intern.ikm.home.index'))
                ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Responden::find($request->id)->delete();

        return redirect(route('intern.ikm.home.index'))->with('success', 'Data Berhasil Dihapus');
    }

    private function setIkmId()
    {
        return Jadwal::select('id')->where('is_open', 1)->first() ?? 1 ;
    }
}
