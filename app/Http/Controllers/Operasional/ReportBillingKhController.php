<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\BaseOperasionalInterface;
use App\Models\Operasional\ReportBillingKh as SetorBilling;
use App\Http\Controllers\Operasional\Upload\UploadFactory;
use App\Http\Requests\UploadOperasionalRequest as Validation;

class ReportBillingKhController extends BaseReportBillingController
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return to view
     */
    public function tableDetailBillingView(Request $request)
    {
        return view('intern.operasional.kh.data.statistik.detail.pnbp.billing');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
     * @return to view
     */
    public function uploadPageView(Request $request)
    {
        return view('intern.operasional.kh.upload.billing');
    }

    /**
     *Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
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

        return back();
	}

    /**
     * API untuk detail big tabel 
     *
     * @param int $year
     * @return datatables JSON
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $setor  = SetorBilling::sortTableDetail([$year, $month, $wilker_id])
                    ->with('wilker')
                    ->get();

        return datatables($setor)->addIndexColumn()->make(true);;
    }
}
