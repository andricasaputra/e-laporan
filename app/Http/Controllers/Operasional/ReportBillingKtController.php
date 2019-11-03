<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Operasional\ReportBillingKt as SetorBilling;
use App\Http\Requests\UploadOperasionalRequest as Validation;

class ReportBillingKtController extends BaseReportBillingController
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function tableDetailPage(Request $request)
    {
        return view('intern.operasional.kt.data.statistik.detail.pnbp.billing');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPage(Request $request)
    {
        return view('intern.operasional.kt.upload.billing');
    }

    /**
     *Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return \Illuminate\Http\Response
     */
    public function imports(Validation $request) 
	{
        // Pertama kita harus memvalidasi laporan yang diuplaod oleh user
        // apabila gagal melakukan validasi maka redirect user kembali
        if (! $this->validateLaporan(new SetorBilling, $request)) {

            return back()->withWarning($this->warning);

        }
        
        // Apabila dokumen laporan valid maka jalankan proses import
        // data kedalam database dan beri notifikasi kepada admin
        // dan pejabat struktural jika laporan belum pernah diupload
        $this->runImportProcess(new SetorBilling);

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
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $setor  = SetorBilling::sortTableDetail([$year, $month, $wilker_id])
                    ->with('wilker')
                    ->get();

        return datatables($setor)->addIndexColumn()->make(true);
    }
}
