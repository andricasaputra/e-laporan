<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Layanan as Model;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan = Model::all();
        
        return view('intern.ikm.layanan.index')->withLayanan($layanan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.ikm.layanan.create');
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

            'layanan' => 'required'

        ]);

        Model::create([

            'jenis_layanan' => $request->layanan

        ]);

        return redirect(route('intern.ikm.layanan.index'))
                ->withSuccess('Data Berhasil Ditambah');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $layanan)
    {
        return view('intern.ikm.layanan.edit')
                ->withLayanan($layanan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $layanan)
    {
        $request->validate([

            'layanan' => 'required'

        ]);

        $layanan->update([

            'jenis_layanan' => $request->layanan

        ]);

        return redirect(route('intern.ikm.layanan.index'))
                ->withSuccess('Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $layanan)
    {
        $layanan->delete();

        return redirect(route('intern.ikm.layanan.index'))
                ->withSuccess('Data Berhasil Dihapus');
    }
}
