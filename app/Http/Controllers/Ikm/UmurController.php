<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Models\Ikm\Umur as Model;
use App\Http\Controllers\Controller;

class UmurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $umur = Model::all();
        
        return view('intern.ikm.umur.index')->withUmur($umur);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.umur.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['umur' => 'required']);

        Model::create(['umur' => $request->umur]);

        return redirect(route('intern.ikm.umur.index'))
                ->withSuccess('Data Berhasil Ditambah');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $umur)
    {
        return view('intern.ikm.umur.edit')->withUmur($umur);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $umur)
    {
        $request->validate(['umur' => 'required']);

        $umur->update(['umur' => $request->umur]);

        return redirect(route('intern.ikm.umur.index'))
                ->withSuccess('Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $umur)
    {
        $umur->delete();

        return redirect(route('intern.ikm.umur.index'))
                ->withSuccess('Data Berhasil Dihapus');
    }
}
