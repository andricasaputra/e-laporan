<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;

class PermintaanDokumenKtController extends BaseOperasionalController
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return to view
     */
    public function tableDetailPembatalanView(Request $request)
    {
        return view('intern.operasional.kt.data.statistik.detail.dokumen.permintaan_dokumen');
    }

    /**
     * Untuk Halaman Rekapitulasi Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return to view
     */
    public function rekapitulasiTableDetail(Request $request)
    {
        // return view('intern.operasional.kt.data.rekapitulasi.dokel_rekapitulasi');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
     */
    public function uploadPageView()
    {
        return view('intern.operasional.kt.upload.permintaan_dokumen');
    }

    /**
     *Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return void
     */
    public function create(Request $request) 
	{
		$request->validate([

			'wilker_id' => 'required'

		]);

		return 'goes here';
	}

    /**
     * API untuk detail tabel 
     *
     * @param int $year
     * @return datatables JSON
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $dokBatal  = Operasional::sortTableDetail($year, $month, $wilker_id)
                        ->with('wilker')
                        ->get();

        return app('DataTables')::of($dokBatal)->addIndexColumn()->make(true);
    }
}
