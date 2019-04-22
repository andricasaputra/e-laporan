<?php

namespace App\Http\Controllers\Operasional\Dokumen;

use Illuminate\Http\Request;
use App\Models\Operasional\Admin\MasterDokumen as Dokumen;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKt as Penerimaan;

class PenerimaanDokumenKtController extends DokumenController
{
    /**
     * Set parent property 
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intern.operasional.kt.dokumen.penerimaan.create')
                ->withDokumens(Dokumen::ktDokumen());
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @param App\Models\Operasional\Dokumen\PenerimaanDokumenKt $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penerimaan $penerimaan)
    {
        return view('intern.operasional.kt.dokumen.penerimaan.edit')
                ->withDokumens(Dokumen::ktDokumen())
                ->withPenerimaan($penerimaan);
    }

    /**
     * Import valid data ke database 
     *
     * @param \Illuminate\Http\lRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $request->validate([

            'wilker_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required'

        ]);
            
        foreach ($request->no_seri as $key => $value) {

            if (strrpos($value, ',')) {

                return back()->withWarning('penulisan nomor seri tidak valid');
            }

            if ($key === 0) {

                Penerimaan::create([

                    'user_id' => $request->user_id,
                    'wilker_id' => $request->wilker_id,
                    'tanggal' => $request->tanggal,
                    'dokumen_id' => $request->dokumen_id,
                    'jumlah' => $request->jumlah,
                    'no_seri' => $value

                ]);

            } else {

                Penerimaan::create([

                    'user_id' => $request->user_id,
                    'wilker_id' => $request->wilker_id,
                    'tanggal' => $request->tanggal,
                    'dokumen_id' => $request->dokumen_id,
                    'jumlah' => 0,
                    'no_seri' => $value

                ]);

            }
        }

        return redirect(route('kt.dokumen.index'))
                ->withSuccess('Data Penerimaan Dokumen Berhasil Ditambah');
    }

    /**
     * Import valid data ke database 
     *
     * @param \Illuminate\Http\Request $request
     * @param App\Models\Operasional\Dokumen\PenerimaanDokumenKt $penerimaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penerimaan $penerimaan) 
    {
        $request->validate([

            'wilker_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required'

        ]);
            
        foreach ($request->no_seri as $key => $value) {

            if (strpos($value, ',') !== false || strpos($value, 's/d') !== false) {

                return back()->withWarning('penulisan nomor seri tidak valid');
            }

            if ($key === 0) {

               $penerimaan->update([

                    'user_id' => $request->user_id,
                    'wilker_id' => $request->wilker_id,
                    'tanggal' => $request->tanggal,
                    'dokumen_id' => $request->dokumen_id,
                    'jumlah' => $request->jumlah,
                    'no_seri' => $value

                ]);

            } else {

                $penerimaan->update([

                    'user_id' => $request->user_id,
                    'wilker_id' => $request->wilker_id,
                    'tanggal' => $request->tanggal,
                    'dokumen_id' => $request->dokumen_id,
                    'jumlah' => 0,
                    'no_seri' => $value

                ]);

            }
        }

        return redirect(route('kt.dokumen.index'))
                ->withSuccess('Data Penerimaan Dokumen Berhasil Diubah');
    }

    /**
     * API data penerimaan dokumen 
     *
     * @return datatables JSON
     */
    public function api()
    {
        return datatables($this->repository->penerimaanTableKt())
                ->addIndexColumn()->addColumn('action', function ($data){
                    return '
                    <a href="'. route('kt.dokumen.penerimaan.edit', $data->id) .'" class="btn btn-primary">
                        <i class="fa fa-edit fa-fw"></i> Edit
                    </a>';
                })->make(true);
    }
}
