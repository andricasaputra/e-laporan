<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\DomasKh as Operasional;

use App\User;

ini_set('max_execution_time', 200);

class DomasKh extends Controller implements OperasionalInterface
{
    /**
     *Ambil Data User Yang Sedang Aktif Dan Kirim ke view 
     *
     * @return to View
     */
    public function sendToUploadDomas()
    {
        $user_id    = Auth::user()->id;

        $user       = User::where('id', $user_id)->first();

        $wilker     = User::find($user_id)->wilker;

        return view('operasional.kh.upload.domas')
        ->with('user', $user)
        ->with('wilker', $wilker);
    }

    /**
     *Digunakan untuk pengecekan wilker pada laporan excel 
     *Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    public function checkUserWilker($path)
    {
        /*Get Format Laporan Untuk Domas*/
        $user_wilker = Excel::selectSheetsByIndex(0)->load($path)->limit(1)->first();


        /*Cek isi file kosong atau tidak*/
        if($user_wilker == null){

            return 'not our format';

        }

        foreach ($user_wilker as $key => $value) {

            /*Get Wilker By Dokumen Yang Diupload*/
            $x      = explode(":", $value);

            $wilker = trim($x[2]);

            if (strpos($wilker, '.') !== false) {

                $wilker = str_replace('.', ' ', $wilker);
            }   

            $wilker = str_replace(' ', '', $wilker);
            
            return trim($wilker);
        }

    }

    /**
     *Digunakan untuk pengecekan jenis karantina apakah sesuai 
     *
     * @return bool
     */
    public function checkJenisKarantina($path)
    {
        /*Get Format Laporan Untuk Domas*/
        $tipe_karantina = Excel::selectSheetsByIndex(0)->load($path)->limit(1)->first();

        /*Cek isi file kosong atau tidak*/
        if($tipe_karantina == null){

            return 'not our format';

        }

        foreach ($tipe_karantina as $key => $value) {

            /*Cek dari value Kosong atau tidak*/
            if ($value == null || strpos($key, 'operasional_karantina_hewan') === false) {

                return false;

            }

            /*Cek Jika File Yang Diunggah File kh */
            return strpos($key, 'operasional_karantina_hewan') ? true : false;
        }

    }

    /**
     *Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    public function checkJenisPermohonan($path)
    {
        /*Get Format Laporan Untuk Domas*/
        $tipe_permohonan = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

            config(['excel.import.startRow' => 2]);

        })->first();

        /*set here*/
        foreach ($tipe_permohonan as $tipe) {

            $lowereing  = strtolower($tipe);

            $getContent = explode(':', $lowereing);

            $tipe       = trim($getContent[1]);

        }

        /*Cek Jika File Yang Diunggah Domestik Masuk */

        return $tipe == 'domestik masuk' ?: false;
    }

    /**
     *Import valid data ke database 
     *
     * @return void
     */
    public function imports(Request $request) 
    {
        $request->validate([

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

            /*Cek Format Laporan*/
            if ($this->checkJenisKarantina($path) === 'not our format') {

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Merupakan Format Laporan Bulanan Dari IQFAST!');

                return redirect()->back();
            }


            /*Cek Jenis Karantina*/
            if($this->checkJenisKarantina($path) === false){

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Untuk Karantina Hewan!');

                return redirect()->back();

            }

            $wilker_laporan_clue = substr($this->checkUserWilker($path), -10, 8);

            /*Cek Wilker Dari User Yang Mengupload - Jika Admin -> abaikan*/
            if(strpos($wilker_user, $wilker_laporan_clue) === false && Auth::user()->role_id != 1){

                \Session::flash('warning','Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!');

                return redirect()->back();
            }

            /*Cek Jenis Permohonan*/
            if ($this->checkJenisPermohonan($path) === false) {

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Domestik Masuk!');

                return redirect()->back();

            }
 
            /*Ambil Bulan Dan Tahun Pada Laporan Di Row 3*/
            $headings = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

                config(['excel.import.startRow' => 3]);

            })->first();

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

                        $domas = new Operasional;

                        $domas->wilker_id = $wilker_id;
                        $domas->user_id = $user_id;
                        $domas->no = $value->no;
                        $domas->bulan = $tanggal_laporan[0];
                        $domas->no_permohonan = $value->no_permohonan;
                        $domas->no_aju = $value->no_aju;
                        $domas->tanggal_permohonan = $value->tanggal_permohonan;
                        $domas->jenis_permohonan = $value->jenis_permohonan;
                        $domas->nama_pemohon = $value->nama_pemohon;
                        $domas->nama_pengirim = $value->nama_pengirim;
                        $domas->alamat_pengirim = $value->alamat_pengirim;
                        $domas->nama_penerima = $value->nama_penerima;
                        $domas->alamat_penerima = $value->alamat_penerima;
                        $domas->jumlah_kemasan = $value->jumlah_kemasan;
                        $domas->kota_asal = $value->kota_asal;
                        $domas->asal = $value->asal;
                        $domas->kota_tujuan = $value->kota_tuju;
                        $domas->tujuan = $value->tujuan;
                        $domas->port_asal = $value->port_asal;
                        $domas->port_tujuan = $value->port_tuju;
                        $domas->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $domas->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $domas->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $domas->status_internal = $value->status_internal;
                        $domas->lokasi_mp = $value->lokasi_mp;
                        $domas->tempat_produksi = $value->tempat_produksi;
                        $domas->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $domas->peruntukan = $value->peruntukan;
                        $domas->golongan = $value->golongan;
                        $domas->kode_hs = $value->kode_hs;
                        $domas->nama_komoditas = $value->nama_komoditas;
                        $domas->nama_komoditas_en = $value->nama_komoditas_en;
                        $domas->volume_netto = $value->volume_netto;
                        $domas->sat_netto = $value->sat_netto;
                        $domas->volume_bruto = $value->volume_bruto;
                        $domas->sat_bruto = $value->sat_bruto;
                        $domas->volume_lain = $value->volume_lain;
                        $domas->sat_lain = $value->sat_lain;
                        $domas->volumeP1 = $value->volumep1;
                        $domas->nettoP1 = $value->nettop1;
                        $domas->volumeP8 = $value->volumep8;
                        $domas->nettoP8 = $value->nettop8;
                        $domas->dok_pelepasan = $value->dok_pelepasan;
                        $domas->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $domas->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $domas->no_seri = $value->no_seri;
                        $domas->dokumen_pendukung = $value->dokumen_pendukung;
                        $domas->kontainer = $value->kontainer;
                        $domas->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $domas->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::where('no_permohonan', $value->no_permohonan)
                        ->where('no_aju', $value->no_aju)->first();

                        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

                        if ($cek !== null) {

                            $success = 1;

                            continue;

                        }else{

                            $domas->save();

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

                $domas = new Operasional;

                $domas->wilker_id = $wilker_id;
                $domas->user_id = $user_id;
                $domas->bulan = $tanggal_laporan[0];

                $domas->save();

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

        \Session::flash('success','Data Berhasil Didownload!');

        return Excel::create('Datas', function($excel) use ($Datas) {
            $excel->sheet('Data Details', function($sheet) use ($Datas){

                $sheet->fromArray($Datas);
                
            });
        })->download('xlsx'); 
  
    }
}

