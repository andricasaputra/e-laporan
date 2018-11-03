<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Ikm\SettingIkm as Setting;
use App\Models\Ikm\Question;
use App\Models\Ikm\Layanan;
use App\Models\Ikm\Umur;
use App\Models\Ikm\Pendidikan;
use App\Models\Ikm\Pekerjaan;
use App\Models\Ikm\Responden;
use App\Models\Ikm\Result;

use DataTables;

class HomeAdminIkm extends Controller
{
    public function api()
    {
        $responden = Responden::with(['layanan', 'umur', 'pekerjaan', 'pendidikan'])->get();

        return Datatables::of($responden)->addIndexColumn()
        ->addColumn('action', function ($responden) {

            return '<a href="'.route('intern.ikm.edit', $responden->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a href="'.route('intern.ikm.show', $responden->id).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>
                <a href="#" data-id = "'.$responden->id.'"  class="btn btn-danger btn-xs" id="deleteIkm"><i class="glyphicon glyphicon-trash"></i> Delete</a>
            ';

        })->rawColumns(['action'])->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailApi($id)
    {
        $result = Result::with(['responden', 'question', 'answer', 'ikm'])->whereIn('responden_id', [$id])->get();

        return Datatables::of($result)->addIndexColumn()->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('intern.ikm.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->detailApi($id);
        $responden = Responden::find($id);
        return view('intern.ikm.show')->with(compact('responden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'hello'. $id;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        dd($request->id);
    }
}
