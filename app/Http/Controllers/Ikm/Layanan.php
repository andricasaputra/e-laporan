<?php

namespace App\Http\Controllers\Ikm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ikm\Layanan as Model;

class Layanan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan = Model::all();
        return view('intern.ikm.layanan.index')->with('layanan', $layanan);
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
        ->with('success', 'Data Berhasil Ditambah');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $layanan = Model::find($id);

        return view('intern.ikm.layanan.edit')->with('layanan', $layanan);
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
        $request->validate([

            'layanan' => 'required'

        ]);

        Model::find($id)->update([

            'jenis_layanan' => $request->layanan

        ]);

        return redirect(route('intern.ikm.layanan.index'))
        ->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Model::destroy($id);

        return redirect(route('intern.ikm.layanan.index'))
        ->with('success', 'Data Berhasil Dihapus');
    }
}
