<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Models\Operasional\ImporKt as Operasional;
use App\Contracts\Operasional\BaseOperasionalInterface;
=======
use App\Contracts\BaseOperasionalInterface;
use App\Models\Operasional\ImporKt as Operasional;
use App\Http\Controllers\Operasional\Upload\UploadFactory;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
use App\Http\Requests\UploadOperasionalRequest as Validation;

ini_set('max_execution_time', '500');

class ImporKtController extends BaseOperasionalController implements BaseOperasionalInterface
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
     */
    public function tableDetailPage(Request $request)
=======
     * @return to view
     */
    public function tableDetailFrekuensiView(Request $request)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return view('intern.operasional.kt.data.statistik.detail.bigtable.impor');
    }

    /**
     * Untuk Halaman Rekapitulasi Laporan 
     *
     * @param Illuminate\Http\Request $request
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
     */
    public function rekapitulasiPage(Request $request)
    {
        return view('intern.operasional.kt.data.rekapitulasi.impor_rekapitulasi');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPage(Request $request)
=======
     * @return to view
     */
    public function rekapitulasiTableDetail(Request $request)
    {
        return view('intern.operasional.kt.data.rekapitulasi.impor_rekapitulasi');
    }

    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
     */
    public function uploadPageView(Request $request)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return view('intern.operasional.kt.upload.impor');
    }

    /**
<<<<<<< HEAD
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
=======
     *Import valid data ke database 
     *
     * @return void
     */
    public function imports(Validation $request) 
    {
        // Filter Data Sebelum Insert Ke Database
        if (! $this->setDataProperty($request, new Operasional)->checkingData() ) return back();

        // Upload Data
        $factory = new UploadFactory();

        $upload  = $factory->initializeUploadType(new Operasional, $request);

        $upload->uploadData();
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

        return back();
    }

    /**
     * API untuk detail big tabel 
     *
<<<<<<< HEAD
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

=======
     * @param int $year
     * @return datatables JSON
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $impor  = Operasional::sortTableDetail([$year, $month, $wilker_id])
                    ->with('wilker')
                    ->get();

        return datatables($impor)->addIndexColumn()->make(true);
    }
}
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
