<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\BaseOperasionalInterface;
use App\Http\Requests\UploadOperasionalRequest as Validation;
use App\Models\Operasional\PembatalanDokKt as Operasional;
use App\Http\Controllers\Operasional\UploadPembatalanController as Upload;

class PembatalanDokKtController extends BaseOperasionalController
{
    /**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return to view
     */
    public function tableDetailPembatalanView(Request $request)
    {
        return view('intern.operasional.kt.data.statistik.detail.dokumen.pembatalan_dokumen');
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

        session()->flash('success','Data Berhasil Didownload!');

        return Excel::create('Datas', function($excel) use ($Datas) {
            $excel->sheet('Data Details', function($sheet) use ($Datas){

                $sheet->fromArray($Datas);
                
            });
        })->download('xlsx');       
  
    }

    /**
     * API untuk detail tabel 
     *
     * @param int $year
     * @return datatables JSON
     */
    public function api($year = null, $month =  null, $wilker_id = null)
    {
        $dokel  = Operasional::sortTableDetail($year, $month, $wilker_id)
                    ->with('wilker')
                    ->get();

        return app('DataTables')::of($dokel)->addIndexColumn()->make(true);
    }
}
