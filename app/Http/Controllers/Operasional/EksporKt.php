<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Operasional\EksporKt as Operasional;

ini_set('max_execution_time', '200');

class EksporKt extends BaseOperasional implements BaseOperasionalInterface
{
    public function sendToData(int $year = null)
    {
        if(!isset($year)) $year = date('Y');
        
        $titles = $this->tableTitleKt();

        return view('intern.operasional.kt.data.tables.ekspor')
        ->with('titles', $titles)
        ->with('tahun', $year);
    }
    /**
     *Ambil Data User Yang Sedang Aktif Dan Kirim ke view 
     *
     * @return to View
     */
    public function sendToUpload()
    {
        $user = $this->setActiveUser();

        $wilker = $this->setActiveUserWilker();

        return view('intern.operasional.kt.upload.ekspor')
        ->with('user', $user)
        ->with('wilker', $wilker);
    }

    /**
     *Import valid data ke database 
     *
     * @return void
     */
    public function imports(Request $request) 
    {
        $request->validate([

            'wilker_id' => 'required',
            'filenya' => 'mimes:xls,xlsx'

        ]);

        $user_id        = $this->checkActiveUserIdAndRequestUserId((int) $request->user_id);

        $wilker_id      = $this->setUserWilkerId((int) $request->wilker_id);

        $wilker_user    = $this->setUserWilker();

        if($request->hasFile('filenya')){

            $path = $request->file('filenya')->getRealPath();

            /*Filter Data Sebelum Insert Database*/
            if($this->checkingData($path, 'operasional_karantina_tumbuhan', 'ekspor', $wilker_user) === false){

                return redirect()->back();

            }
 
            /*Delegate Upload Process to Upload Class*/
            $upload     = new Upload(new Operasional, $request, $path, 'kt');

            $process    = $upload->uploadData();

        /*Jika file ksoong tampilkan pesan error*/    
        }else{

            \Session::flash('warning','Harap Pilih File Untuk Diimport Terlebih Dahulu!');

        }

        return redirect()->back();

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
        
        \Session::flash('success','Data Berhasil Didownload!');
  
    }

    public function api(int $year)
    {
        $ekspor = Operasional::whereYear('bulan', $year)->with('wilker')->get();

        return Datatables::of($ekspor)->addIndexColumn()->make(true);
    }
}
