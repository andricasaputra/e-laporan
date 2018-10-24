<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\ImporKt as Operasional;

use App\User;

ini_set('max_execution_time', 200);

class ImporKt extends Controller
{
	/**
     *Ambil Data User Yang Sedang Aktif Dan Kirim ke view 
     *
     * @return to View
     */
    public function sendToUploadImpor()
    {
        $user_id    = Auth::user()->id;

        $user       = User::where('id', $user_id)->first();

        $wilker     = User::find($user_id)->wilker;

        return view('operasional.kt.upload.impor')
        ->with('user', $user)
        ->with('wilker', $wilker);
    }

    /**
     *Digunakan untuk pengecekan jenis karantina apakah sesuai 
     *
     * @return bool
     */
    private function checkJenisKarantina($path)
    {
        /*Get Format Laporan Untuk impor*/
        $tipe_karantina = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

            config(['excel.import.startRow' => 1]);

        })->limit(1)->first();

        /*Cek isi file kosong atau tidak*/
        if($tipe_karantina == null){

            return 'not our format';

        }

        foreach ($tipe_karantina as $key => $value) {
            /*Cek Jika File Yang Diunggah File KT */
            return strpos($key, 'operasional_karantina_tumbuhan') ? true : false;
        }

    }

    /**
     *Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    private function checkJenisPermohonan($path)
    {
        /*Get Format Laporan Untuk impor*/
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

        return $tipe == 'impor' ?: false;
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

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Untuk Karantina Tumbuhan!');

                return redirect()->back();

            }

            /*Cek Jenis Permohonan*/
            if ($this->checkJenisPermohonan($path) === false) {

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Kegiatan Impor!');

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

                        $impor = new Operasional;

                        $impor->wilker_id = $wilker_id;
                        $impor->user_id = $user_id;
                        $impor->no = $value->no;
                        $impor->bulan = $tanggal_laporan[0];
                        $impor->no_permohonan = $value->no_permohonan;
                        $impor->no_aju = $value->no_aju;
                        $impor->tanggal_permohonan = $value->tanggal_permohonan;
                        $impor->jenis_permohonan = $value->jenis_permohonan;
                        $impor->nama_pemohon = $value->nama_pemohon;
                        $impor->nama_pengirim = $value->nama_pengirim;
                        $impor->alamat_pengirim = $value->alamat_pengirim;
                        $impor->nama_penerima = $value->nama_penerima;
                        $impor->alamat_penerima = $value->alamat_penerima;
                        $impor->jumlah_kemasan = $value->jumlah_kemasan;
                        $impor->kota_asal = $value->kota_asal;
                        $impor->asal = $value->asal;
                        $impor->kota_tujuan = $value->kota_tuju;
                        $impor->tujuan = $value->tujuan;
                        $impor->port_asal = $value->port_asal;
                        $impor->port_tujuan = $value->port_tuju;
                        $impor->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $impor->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $impor->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $impor->status_internal = $value->status_internal;
                        $impor->lokasi_mp = $value->lokasi_mp;
                        $impor->tempat_produksi = $value->tempat_produksi;
                        $impor->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $impor->peruntukan = $value->peruntukan;
                        $impor->golongan = $value->golongan;
                        $impor->kode_hs = $value->kode_hs;
                        $impor->nama_komoditas = $value->nama_komoditas;
                        $impor->nama_komoditas_en = $value->nama_komoditas_en;
                        $impor->volume_netto = $value->volume_netto;
                        $impor->sat_netto = $value->sat_netto;
                        $impor->volume_bruto = $value->volume_bruto;
                        $impor->sat_bruto = $value->sat_bruto;
                        $impor->volume_lain = $value->volume_lain;
                        $impor->sat_lain = $value->sat_lain;
                        $impor->volumeP1 = $value->volumep1;
                        $impor->nettoP1 = $value->nettop1;
                        $impor->volumeP8 = $value->volumep8;
                        $impor->nettoP8 = $value->nettop8;
                        $impor->dok_pelepasan = $value->dok_pelepasan;
                        $impor->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $impor->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $impor->no_seri = $value->no_seri;
                        $impor->dokumen_pendukung = $value->dokumen_pendukung;
                        $impor->kontainer = $value->kontainer;
                        $impor->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $impor->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::where('no_permohonan', $value->no_permohonan)
                        ->where('no_aju', $value->no_aju)->first();

                        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

                        if ($cek !== null) {

                            $success = 1;

                            continue;

                        }else{

                            $impor->save();

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

                $impor = new Operasional;

                $impor->wilker_id = $wilker_id;
                $impor->user_id = $user_id;
                $impor->bulan = $tanggal_laporan[0];

                $impor->save();

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
}
