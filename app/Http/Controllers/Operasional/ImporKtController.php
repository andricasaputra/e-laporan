<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\BaseOperasionalInterface;
use App\Models\Operasional\ImporKt as Operasional;
use App\Http\Requests\UploadOperasionalRequest as Validation;
use App\Http\Controllers\Operasional\UploadController as Upload;

ini_set('max_execution_time', '200');

class ImporKtController extends BaseOperasionalController implements BaseOperasionalInterface
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return to view
     */
    public function tableDetailFrekuensiView(Request $request)
    {
        return view('intern.operasional.kt.data.statistik.detail.frekuensi.impor');
    }

    /**
     * Untuk Halaman Rekapitulasi Laporan 
     *
     * @param Illuminate\Http\Request $request
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
    public function uploadPageView()
    {
        return view('intern.operasional.kt.upload.impor');
    }

    /**
     *Import valid data ke database 
     *
     * @return void
     */
    public function imports(Validation $request) 
    {
        if (! $request->hasFile('filenya')) {

             session()->flash('warning','Harap Pilih File Untuk Diimport Terlebih Dahulu!');

             return back();
        }

        $this->setDataProperty($request, new Operasional);

        /*Filter Data Sebelum Insert Database*/
        if ($this->checkingData() === false) return back();

        /*Delegate Upload Process to Upload Class*/
        (new Upload( new Operasional, $request ))->uploadData();

        return back();
    }

    /**
     *Export data dengan format excel dari database
     *
     * @return void
     */
    public function exports($tahun = '', $bulan = 'all')
    {

        if ($tahun != '') :
            
            if ($bulan != 'all') {
                
                $Datas = Operasional::whereMonth('tanggal_permohonan', $bulan)->get()->toArray();
                
            }else{

                $Datas = Operasional::whereYear('tanggal_permohonan', $tahun)->get()->toArray();

            }

        else :

            if ($bulan != 'all') {
                
                $Datas = Operasional::whereMonth('tanggal_permohonan', $bulan)->get()->toArray();

            }else{

                $Datas = Operasional::all()->toArray();
            }

        endif;

        return Excel::create('Datas', function($excel) use ($Datas) {

            $excel->sheet('Data Details', function($sheet) use ($Datas){

                $sheet->fromArray($Datas);
                
            });

        })->download('xlsx');
        
        session()->flash('success','Data Berhasil Didownload!');
  
    }

    public function api(int $year)
    {
        $impor = Operasional::whereYear('bulan', $year)->with('wilker')->get();

        return app('DataTables')::of($impor)->addIndexColumn()->make(true);
    }
}
