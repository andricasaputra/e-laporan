<?php

namespace App\Http\Controllers\Operasional\Dokumen;

use Illuminate\Http\Request;
use App\Models\Operasional\Admin\MasterDokumen as Dokumen;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKh as Penerimaan;

class PenerimaanDokumenKhController extends DokumenController
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
        return view('intern.operasional.kh.dokumen.penerimaan.create')
                ->withDokumens(Dokumen::khDokumen());
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
     */
    public function edit(Penerimaan $penerimaan)
    {
        return view('intern.operasional.kh.dokumen.penerimaan.edit')
                ->withDokumens(Dokumen::khDokumen())
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

		return redirect(route('kh.dokumen.index'))
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

            'wilker_id' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required'

        ]);

        foreach ($request->no_seri as $key => $value) {

            if (strrpos($value, ',')) {

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

        return redirect(route('kh.dokumen.index'))
                ->withSuccess('Data Penerimaan Dokumen Berhasil Diubah');
    }

    /**
     * API data penerimaan dokumen 
     *
     * @return datatables JSON
     */
    public function api()
    {
        return datatables($this->repository->penerimaanTableKh())
            ->addIndexColumn()->addColumn('action', function ($data){
                return '
                <a href="'. route('kh.dokumen.penerimaan.edit', $data->id) .'" class="btn btn-primary">
                    <i class="fa fa-edit fa-fw"></i> Edit
                </a>';
            })->make(true);
    }
}
