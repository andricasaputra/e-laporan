<?php

namespace App\Http\Controllers\Penugasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Operasional\TablePenugasanlHeader;
use App\Repositories\PenugasanRepository as Repository;
use App\Models\Penugasan\PenugasanDokelKt as Penugasan;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class PenugasanDokelKtController extends BaseOperasionalController
{
    use TablePenugasanlHeader;

    public $repository;

    public function __construct(Request $request)
    {
        $this->repository = new Repository($request);

    }

    public function menu()
    {
        return view('intern.penugasan.kt.menu');
    }

    public function home()
    {
        return view('intern.penugasan.kt.upload.home');
    }

    public function uploadPage()
    {
        return view('intern.penugasan.kt.upload.dokel');
    }

    public function dataPage()
    {
         return view('intern.penugasan.kt.data.home')
            ->withDatas($this->repository->getRouteParams())
            ->withHeaderstable($this->tableHeaderPenugasan());
    }

    public function upload(Request $request)
    {
         // Pertama kita harus memvalidasi laporan yang diuplaod oleh user
        // apabila gagal melakukan validasi maka redirect user kembali
        if (! $this->validateLaporan(new Penugasan, $request)) {

            return back()->withWarning($this->warning);

        }
        
        // Apabila dokumen laporan valid maka jalankan proses import
        // data kedalam database dan beri notifikasi kepada admin
        // dan pejabat struktural jika laporan belum pernah diupload
        $this->runImportProcess(new Penugasan);

        return back();
    }

    public function tableData($year = null, $month = null, $wilkerId = null)
    {
        $params         = [$year, $month, $wilkerId];

        $penugasan    = Penugasan::sortTableDetail($params)->with('wilker')->get();

        return datatables($penugasan)
            ->addIndexColumn() 
            ->editColumn('created_at', function ($penugasan) {
                  return $penugasan->created_at->format('d-m-Y');
           })
            ->removeColumn('user_id')
            ->removeColumn('wilker_id')
            ->make(true);
    }
}
