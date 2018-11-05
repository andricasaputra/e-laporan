<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Jadwal;
use App\Models\Ikm\Question;
use App\Models\Ikm\Layanan;
use App\Models\Ikm\Umur;
use App\Models\Ikm\Pendidikan;
use App\Models\Ikm\Pekerjaan;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Result;
use App\Models\Ikm\Answer;
use DataTables;

class Home extends Controller
{
    public function api($year)
    {
        $responden = Responden::with([
                'layanan', 
                'umur',
                'pekerjaan', 
                'pendidikan', 
                'ikm',
                'answer'
        ])->whereYear('created_at', $year)
        ->orderBy('created_at', 'desc')->get();

        return Datatables::of($responden)->addIndexColumn()
        ->addColumn('action', function ($responden) {

            return '<a href="'.route('intern.ikm.home.edit', $responden->id).'" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Edit
                    </a>
                    <a href="'.route('intern.ikm.home.show', [$responden->id, $responden->created_at->year]).'" class="btn btn-xs btn-success">
                        <i class="glyphicon glyphicon-eye-open"></i> Detail
                    </a>
                    <a href="#" data-id = "'.$responden->id.'"  class="btn btn-danger btn-xs" id="deleteIkm">
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </a>
            ';

        })->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailApi($id, $year)
    {
        $result = Result::with([
            'responden', 
            'question', 
            'answer', 
            'ikm'
        ])->whereIn('responden_id', [$id])->whereYear('created_at', $year)->get();

        return Datatables::of($result)->addIndexColumn()->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year = null)
    {
        $tahun = !isset($year) ? date('Y') : $year ;

        return view('intern.ikm.home.index')->with(compact('tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.home.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $year)
    {
        $responden = Responden::find($id);
        return view('intern.ikm.home.show')->with(compact('responden'))
        ->with(compact('year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $responden  = Responden::find($id);
        $jawaban    = Answer::all();

        return view('intern.ikm.home.edit')
        ->with('responden', $responden)
        ->with('jawaban', $jawaban);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $responden = Responden::find($id);

        $answer = $request->except([
            'responden_id',
            'submit',
            '_method',
            '_token',
        ]);

        $no = 0;

        for ($i=0; $i < count($answer[$id]); $i++) { 

            $result = Result::where('responden_id', $id)
            ->where('answer_id', $responden->result[$i]->answer_id)->first();

            $result->answer_id = $answer[$id][$i];

            $result->save();

        }

        return redirect(route('intern.ikm.home.index'))->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $responden = Responden::find($request->id);

        $responden->delete();

        return redirect(route('intern.ikm.home.index'))->with('success', 'Data Berhasil Dihapus');

    }
}
