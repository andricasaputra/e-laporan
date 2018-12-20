<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Pendidikan as Model;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendidikan = Model::all();
        
        return view('intern.ikm.pendidikan.index')
                ->with('pendidikan', $pendidikan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.pendidikan.create');
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

            'pendidikan' => 'required'

        ]);

        Model::create([

            'pendidikan' => $request->pendidikan

        ]);

        return redirect(route('intern.ikm.pendidikan.index'))
                ->with('success', 'Data Berhasil Ditambah');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $pendidikan)
    {
        return view('intern.ikm.pendidikan.edit')
                ->with('pendidikan', $pendidikan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $pendidikan)
    {
        $request->validate([

            'pendidikan' => 'required'

        ]);

        $pendidikan->update([

            'pendidikan' => $request->pendidikan

        ]);

        return redirect(route('intern.ikm.pendidikan.index'))
                ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $pendidikan)
    {
        $pendidikan->delete();

        return redirect(route('intern.ikm.pendidikan.index'))
                ->with('success', 'Data Berhasil Dihapus');
    }
}
