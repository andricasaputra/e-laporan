<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Models\Operasional\SerahTerimaKt as Operasional;
use App\Contracts\Operasional\BaseOperasionalInterface;
use App\Http\Requests\UploadOperasionalRequest as Validation;

ini_set('max_execution_time', '500');

class SerahTerimaKtController extends BaseOperasionalController implements BaseOperasionalInterface
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function tableDetailPage(Request $request)
    {
        return view('intern.operasional.kt.data.statistik.detail.bigtable.serah_terima');
    }

    /**
     * Untuk Halaman Rekapitulasi Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function rekapitulasiPage(Request $request)
    {
        return view('intern.operasional.kt.data.rekapitulasi.serah_terima_rekapitulasi');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPage(Request $request)
    {
        return view('intern.operasional.kt.upload.serah_terima');
    }

    /**
     * Import data laporan excel ke dalam database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return \Illuminate\Http\Response
     */
    public function imports(Validation $request)
    {
        // Pertama kita harus memvalidasi laporan yang diuplaod oleh user
        // apabila gagal melakukan validasi maka redirect user kembali
        if (! $this->validateLaporan(new Operasional, $request)) {

            return back()->withWarning($this->warning);

        }
        
        // Apabila dokumen laporan valid maka jalankan proses import
        // data kedalam database dan beri notifikasi kepada admin
        // dan pejabat struktural jika laporan belum pernah diupload
        $this->runImportProcess(new Operasional);

        return back();
    }

    /**
     * API untuk detail big tabel 
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return array
     */
    public function api($year = null, $month = null, $wilkerId = null)
    {
        $params         = [$year, $month, $wilkerId];

        $operasional    = Operasional::sortTableDetail($params)->with('wilker')->get();

        return datatables($operasional)->addIndexColumn()->make(true);
    }
}
