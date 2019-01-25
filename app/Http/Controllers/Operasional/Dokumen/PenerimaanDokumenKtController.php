<?php

namespace App\Http\Controllers\Operasional\Dokumen;

use Illuminate\Http\Request;
use App\Models\Operasional\Admin\MasterDokumen as Dokumen;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKt as Penerimaan;

class PenerimaanDokumenKtController extends DokumenController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
     */
    public function create()
    {
        return view('intern.operasional.kt.dokumen.penerimaan.create')
                ->withDokumens(Dokumen::ktDokumen());
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
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
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return void
     */
    public function store(Request $request) 
    {
        $request->validate([

            'wilker_id' => 'required'

        ]);

        if (is_array($request->no_seri)) {
            
            foreach ($request->no_seri as $key => $value) {

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

        } else {

            Penerimaan::create($request->all());

        }

        return redirect(route('kt.dokumen.index'))
                ->withSuccess('Data Penerimaan Dokumen Berhasil Ditambah');
    }

    /**
     * Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return void
     */
    public function update(Request $request, Penerimaan $penerimaan) 
    {
        $request->validate([

            'wilker_id' => 'required'

        ]);

        if (is_array($request->no_seri)) {
            
            foreach ($request->no_seri as $key => $value) {

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

        } else {

            $penerimaan->update($request->all());

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
