<?php

namespace App\Http\Controllers\Operasional\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Operasional\Admin\MasterDokumen as Dokumen;

class DokumenSettingController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('intern.operasional.admin.setting.dokumen.index')
    			->withDokumens(Dokumen::all());
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

            'dokumen' => 'required|min:4|max:10|unique:master_dokumen',
            'deskripsi' => 'required',
            'karantina' => 'required'

        ]);

    	Dokumen::updateOrCreate(
            ['dokumen' => str_replace(' ', '-', $request->dokumen)],
            ['deskripsi' => $request->deskripsi, 'karantina' => $request->karantina]
        );

    	return redirect(route('admin.setting.dokumen.index'))
    			->withSuccess('Data Dokumen Berhasil Ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return view('intern.operasional.admin.setting.dokumen.edit')
    			->withDokumen(Dokumen::find($id));
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

    		'dokumen' => 'required|min:4|max:10',
    		'deskripsi' => 'required',
    		'karantina' => 'required'

    	]);

    	Dokumen::find($id)->update($request->all());

    	return redirect(route('admin.setting.dokumen.index'))
    			->withSuccess('Data Dokumen Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	Dokumen::destroy($id);

    	return redirect(route('admin.setting.dokumen.index'))
    			->withSuccess('Data Dokumen Berhasil Dihapus');
    }
}
