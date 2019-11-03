<?php

namespace App\Http\Controllers\Operasional\Dokumen;

use Illuminate\Http\Request;
use App\Http\Requests\UploadOperasionalRequest as Validation;
<<<<<<< HEAD
use App\Models\Operasional\Dokumen\PembatalanDokKt as Operasional;
use App\Http\Controllers\Operasional\BasePembatalanDokumenController;

ini_set('max_execution_time', '500');

class PembatalanDokKtController extends BasePembatalanDokumenController
=======
use App\Http\Controllers\Operasional\BaseOperasionalController;
use App\Models\Operasional\Dokumen\PembatalanDokKt as Operasional;
use App\Http\Controllers\Operasional\UploadPembatalanController as Upload;

ini_set('max_execution_time', '500');

class PembatalanDokKtController extends BaseOperasionalController
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
{
    /**
     * menyimpan instance dari repository yang dipakai
     *
     * @var App\Repositories\Operasional\DokumenRepository
     */
    private $repository;

    /**
     * Set properties untuk class ini
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->repository = (new DokumenController($request))->getRepository();
    }

    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
<<<<<<< HEAD
     * @return void
     */
    public function tableDetailPage(Request $request)
    {
        // belum dibuat
        // return view('intern.operasional.kt.dokumen.detail');
=======
     * @return to view
     */
    public function tableDetailPembatalanView(Request $request)
    {
        return view('intern.operasional.kt.data.dokumen.pembatalan_dokumen');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
    
    /**
     * Untuk Halaman Upload Laporan 
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function uploadPage()
=======
     * @return to view
     */
    public function uploadPageView()
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        return view('intern.operasional.kt.upload.pembatalan_dokumen');
    }

    /**
     *Import valid data ke database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return void
     */
    public function imports(Validation $request) 
	{
<<<<<<< HEAD
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
        /*Filter Data Sebelum Insert Database*/
        if (! $this->setDataProperty($request, new Operasional)->checkingData() ) return back();

        /*Delegate Upload Process to Upload Class*/
        (new Upload( new Operasional, $request ))->uploadData();
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

        return back();
	}

    /**
     * API data pembatalan dokumen 
     *
<<<<<<< HEAD
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return array
=======
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return datatables JSON
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        return datatables($this->repository->pembatalanTableKt())
            ->addIndexColumn()->addColumn('action', function ($data){
                return '
                <a href="#" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Edit
                </a>';
            })->make(true);
    }
}
