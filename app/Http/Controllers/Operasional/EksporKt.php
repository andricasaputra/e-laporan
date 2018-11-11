<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\EksporKt as Operasional;
use App\User;
use App\Wilker;
use DataTables;

ini_set('max_execution_time', 200);

class EksporKt extends BaseOperasional implements BaseOperasionalInterface
{
    public function sendToData($year = null)
    {
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
        $user_id    = Auth::user()->id;

        $user       = User::where('id', $user_id)->first();

        if (Auth::user()->role_id == 1) {

            $wilker     = Wilker::where('nama_wilker', '!=', 'Kantor induk')->get();

        }else{

            $wilker     = User::find($user_id)->wilker->toArray();
        }

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

        $user_id = $request->user_id;

        $wilker_user = User::find($user_id)->wilker;

        $wilker_user = $wilker_user->nama_wilker;

        if (strpos($wilker_user, '.') !== false) {

            $wilker_user = str_replace('.', ' ', $wilker_user);
        }

        $wilker_user = str_replace(' ', '', $wilker_user);

        $wilker_id = $request->wilker_id;

        if($request->hasFile('filenya')){

            $path = $request->file('filenya')->getRealPath();

            /*Filter Data Sebelum Insert Database*/
            if($this->checkingData($path, 'operasional_karantina_tumbuhan', 'ekspor', $wilker_user) === false){

                return redirect()->back();

            }
 
            /*Ambil Bulan Dan Tahun Pada Laporan Di Row 3*/
            $headings = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

                config(['excel.import.startRow' => 3]);

            })->first()->toArray();

            /*Data Asli Dimulai Dari Row Ke 7*/
            $datas = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
                
                config(['excel.import.startRow' => 7]);

            })->get();

            /*set tanggal format Y-m-d*/
            foreach ($headings as $heading) {
                $lowereing  = strtolower($heading);
                $getContent = explode(' ', $lowereing);
                $bulan      = $getContent[2];
                $tahun      = $getContent[6];
                $tanggal_laporan[] = $tahun.'-'.$bulan.'-01';
            }

            $success = 0;

            /*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
            if (!empty($datas) && $datas->count() > 0) :

                    foreach ($datas as $key => $value) :

                        $ekspor = new Operasional;

                        $ekspor->wilker_id = $wilker_id;
                        $ekspor->user_id = $user_id;
                        $ekspor->no = $value->no;
                        $ekspor->bulan = $tanggal_laporan[0];
                        $ekspor->no_permohonan = $value->no_permohonan;
                        $ekspor->no_aju = $value->no_aju;
                        $ekspor->tanggal_permohonan = $value->tanggal_permohonan;
                        $ekspor->jenis_permohonan = $value->jenis_permohonan;
                        $ekspor->nama_pemohon = $value->nama_pemohon;
                        $ekspor->nama_pengirim = $value->nama_pengirim;
                        $ekspor->alamat_pengirim = $value->alamat_pengirim;
                        $ekspor->nama_penerima = $value->nama_penerima;
                        $ekspor->alamat_penerima = $value->alamat_penerima;
                        $ekspor->jumlah_kemasan = $value->jumlah_kemasan;
                        $ekspor->kota_asal = $value->kota_asal;
                        $ekspor->asal = $value->asal;
                        $ekspor->kota_tujuan = $value->kota_tuju;
                        $ekspor->tujuan = $value->tujuan;
                        $ekspor->port_asal = $value->port_asal;
                        $ekspor->port_tujuan = $value->port_tuju;
                        $ekspor->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $ekspor->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $ekspor->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $ekspor->status_internal = $value->status_internal;
                        $ekspor->lokasi_mp = $value->lokasi_mp;
                        $ekspor->tempat_produksi = $value->tempat_produksi;
                        $ekspor->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $ekspor->peruntukan = $value->peruntukan;
                        $ekspor->golongan = $value->golongan;
                        $ekspor->kode_hs = $value->kode_hs;
                        $ekspor->nama_komoditas = $value->nama_komoditas;
                        $ekspor->nama_komoditas_en = $value->nama_komoditas_en;
                        $ekspor->volume_netto = $value->volume_netto;
                        $ekspor->sat_netto = $value->sat_netto;
                        $ekspor->volume_bruto = $value->volume_bruto;
                        $ekspor->sat_bruto = $value->sat_bruto;
                        $ekspor->volume_lain = $value->volume_lain;
                        $ekspor->sat_lain = $value->sat_lain;
                        $ekspor->volumeP1 = $value->volumep1;
                        $ekspor->nettoP1 = $value->nettop1;
                        $ekspor->volumeP8 = $value->volumep8;
                        $ekspor->nettoP8 = $value->nettop8;
                        $ekspor->dok_pelepasan = $value->dok_pelepasan;
                        $ekspor->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $ekspor->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $ekspor->no_seri = $value->no_seri;
                        $ekspor->dokumen_pendukung = $value->dokumen_pendukung;
                        $ekspor->kontainer = $value->kontainer;
                        $ekspor->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $ekspor->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::where('nomor_dok_pelepasan', $value->nomor_dok_pelepasan)
                        ->where('no_seri', $value->no_seri)
                        ->where('tanggal_pelepasan', $value->tanggal_pelepasan)
                        ->where('no_permohonan', $value->no_permohonan)->first();

                        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

                        if ($cek !== null) {

                            $success = 1;

                            continue;

                        }else{

                            $ekspor->save();

                            $success = 2;
                        }

                    endforeach;

                    /*Jika data berhasil di insert ke database*/ 
                    if ($success > 0) {

                        /*Jika data berhasil di insert ke database tetapi file sudah pernah diupload tampilkan pesan*/ 
                        if ($success == 1) {
                        
                            \Session::flash('success','File Sudah Pernah Diunggah, Tidak Ada Data Untuk Diperbarui!');

                        }else{

                            \Session::flash('success','Data Berhasil Diimport!');

                        }       

                    /*Error tidak terduga / bad connection??*/
                    }else{

                        \Session::flash('warning','Gagal Import Data!');

                    }
            else:

                $ekspor = new Operasional;

                $ekspor->wilker_id = $wilker_id;
                $ekspor->user_id = $user_id;
                $ekspor->bulan = $tanggal_laporan[0];

                $ekspor->save();

                \Session::flash('success','Data Berhasil Diimport!');

            endif;

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

    public function api($year)
    {
        $ekspor = Operasional::whereYear('bulan', $year);

        return Datatables::of($ekspor)->addIndexColumn()->make(true);
    }
}
