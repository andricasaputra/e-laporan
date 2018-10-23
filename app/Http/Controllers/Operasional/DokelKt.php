<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\DokelKt as Operasional;

use App\User;

class DokelKt extends Controller
{
    /**
     *Ambil Data User Yang Sedang Aktif Dan Kirim ke view 
     *
     * @return to View
     */
    public function sendToUploadDokel()
    {
        $user_id    = Auth::user()->id;

        $user       = User::where('id', $user_id)->first();

        $wilker     = User::find($user_id)->wilker;

        return view('operasional.kt.upload.dokel')
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
        /*Get Format Laporan Untuk Dokel*/
        $tipe_karantina = Excel::selectSheets('Sheet1')->load($path, function($reader) {

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
        /*Get Format Laporan Untuk Dokel*/
        $tipe_permohonan = Excel::selectSheets('Sheet1')->load($path, function($reader) {

            config(['excel.import.startRow' => 2]);

        })->first();

        /*set here*/
        foreach ($tipe_permohonan as $tipe) {

            $lowereing  = strtolower($tipe);

            $getContent = explode(':', $lowereing);

            $tipe       = trim($getContent[1]);

        }

        /*Cek Jika File Yang Diunggah Domestik Keluar */

        return $tipe == 'domestik keluar' ?: false;
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

                \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Domestik Keluar!');

                return redirect()->back();

            }
 
            /*Ambil Bulan Dan Tahun Pada Laporan Di Row 3*/
            $headings = Excel::selectSheets('Sheet1')->load($path, function($reader) {

                config(['excel.import.startRow' => 3]);

            })->first();

            /*Data Asli Dimulai Dari Row Ke 7*/
            $datas = Excel::selectSheets('Sheet1')->load($path, function($reader) {
                
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

                        $dokel = new Operasional;

                        $dokel->wilker_id = $wilker_id;
                        $dokel->user_id = $user_id;
                        $dokel->no = $value->no;
                        $dokel->bulan = $tanggal_laporan[0];
                        $dokel->no_permohonan = $value->no_permohonan;
                        $dokel->no_aju = $value->no_aju;
                        $dokel->tanggal_permohonan = $value->tanggal_permohonan;
                        $dokel->jenis_permohonan = $value->jenis_permohonan;
                        $dokel->nama_pemohon = $value->nama_pemohon;
                        $dokel->nama_pengirim = $value->nama_pengirim;
                        $dokel->alamat_pengirim = $value->alamat_pengirim;
                        $dokel->nama_penerima = $value->nama_penerima;
                        $dokel->alamat_penerima = $value->alamat_penerima;
                        $dokel->jumlah_kemasan = $value->jumlah_kemasan;
                        $dokel->kota_asal = $value->kota_asal;
                        $dokel->asal = $value->asal;
                        $dokel->kota_tujuan = $value->kota_tuju;
                        $dokel->tujuan = $value->tujuan;
                        $dokel->port_asal = $value->port_asal;
                        $dokel->port_tujuan = $value->port_tuju;
                        $dokel->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $dokel->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $dokel->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $dokel->status_internal = $value->status_internal;
                        $dokel->lokasi_mp = $value->lokasi_mp;
                        $dokel->tempat_produksi = $value->tempat_produksi;
                        $dokel->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $dokel->peruntukan = $value->peruntukan;
                        $dokel->golongan = $value->golongan;
                        $dokel->kode_hs = $value->kode_hs;
                        $dokel->nama_komoditas = $value->nama_komoditas;
                        $dokel->nama_komoditas_en = $value->nama_komoditas_en;
                        $dokel->volume_netto = $value->volume_netto;
                        $dokel->sat_netto = $value->sat_netto;
                        $dokel->volume_bruto = $value->volume_bruto;
                        $dokel->sat_bruto = $value->sat_bruto;
                        $dokel->volume_lain = $value->volume_lain;
                        $dokel->sat_lain = $value->sat_lain;
                        $dokel->volumeP1 = $value->volumep1;
                        $dokel->nettoP1 = $value->nettop1;
                        $dokel->volumeP8 = $value->volumep8;
                        $dokel->nettoP8 = $value->nettop8;
                        $dokel->dok_pelepasan = $value->dok_pelepasan;
                        $dokel->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $dokel->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $dokel->no_seri = $value->no_seri;
                        $dokel->dokumen_pendukung = $value->dokumen_pendukung;
                        $dokel->kontainer = $value->kontainer;
                        $dokel->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $dokel->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::where('no_permohonan', $value->no_permohonan)
                        ->where('no_aju', $value->no_aju)->first();

                        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

                        if ($cek !== null) {

                            $success = 1;

                            continue;

                        }else{

                            $dokel->save();

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

