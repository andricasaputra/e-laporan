<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Pekerjaan as Model;

class Pekerjaan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pekerjaan = Model::all();
        return view('intern.ikm.pekerjaan.index')->with('pekerjaan', $pekerjaan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.pekerjaan.create');
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

            'pekerjaan' => 'required'

        ]);

        Model::create([

            'pekerjaan' => $request->pekerjaan

        ]);

        return redirect(route('intern.ikm.pekerjaan.index'))
        ->with('success', 'Data Berhasil Ditambah');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $pekerjaan = Model::find($id);

        return view('intern.ikm.pekerjaan.edit')->with('pekerjaan', $pekerjaan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([

            'pekerjaan' => 'required'

        ]);

        Model::find($id)->update([

            'pekerjaan' => $request->pekerjaan

        ]);

        return redirect(route('intern.ikm.pekerjaan.index'))
        ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Model::destroy($id);

        return redirect(route('intern.ikm.pekerjaan.index'))
        ->with('success', 'Data Berhasil Dihapus');
    }
}
