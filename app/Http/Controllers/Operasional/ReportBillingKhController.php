<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\BaseOperasionalInterface;
<<<<<<< HEAD
use App\Factories\Operasional\UploadFactory;
use App\Models\Operasional\ReportBillingKh as SetorBilling;
=======
use App\Models\Operasional\ReportBillingKh as SetorBilling;
use App\Http\Controllers\Operasional\Upload\UploadFactory;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
use App\Http\Requests\UploadOperasionalRequest as Validation;

class ReportBillingKhController extends BaseReportBillingController
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
    public function tableDetailBillingView(Request $request)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return view('intern.operasional.kh.data.statistik.detail.pnbp.billing');
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
     */
    public function uploadPage(Request $request)
=======
     * @return to view
     */
    public function uploadPageView(Request $request)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return view('intern.operasional.kh.upload.billing');
    }

    /**
     *Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return array
=======
     * @param int $year
     * @return datatables JSON
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $setor  = SetorBilling::sortTableDetail([$year, $month, $wilker_id])
                    ->with('wilker')
                    ->get();

        return datatables($setor)->addIndexColumn()->make(true);;
    }
}
