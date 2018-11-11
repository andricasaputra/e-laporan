<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

ini_set('max_execution_time', 200);

class BaseOperasional extends Controller
{
    /*Menangkap URL Request Kemudian Di Redirect*/
    protected function selectAnotherYear(Request $request)
    {
        return redirect($request->year);
    }
    /**
     *Digunakan mencetak semua table kt head pada masing2 class turunan
     *dan kemuadian masing2 child class mengoper ke view yang diperlukan 
     *
     * @return array
     */
    protected function tableTitleKt()
    {
        return array(
             'no',
             'bulan',
             'no_permohonan',
             'no_aju',
             'tanggal_permohonan',
             'jenis_permohonan',
             'nama_pemohon',
             'nama_pengirim',
             'alamat_pengirim',
             'nama_penerima',
             'alamat_penerima',
             'jumlah_kemasan',
             'kota_asal',
             'asal',
             'kota_tujuan',
             'tujuan',
             'port_asal',
             'port_tujuan',
             'moda_alat_angkut_terakhir',
             'tipe_alat_angkut_terakhir',
             'nama_alat_angkut_terakhir',
             'status_internal',
             'lokasi_mp',
             'tempat_produksi',
             'nama_tempat_pelaksanaan',
             'peruntukan',
             'golongan',
             'kode_hs',
             'nama_komoditas',
             'nama_komoditas_en',
             'volume_netto',
             'sat_netto',
             'volume_bruto',
             'sat_bruto',
             'volume_lain',
             'sat_lain',
             'volumeP1',
             'nettoP1',
             'volumeP8',
             'nettoP8',
             'dok_pelepasan',
             'nomor_dok_pelepasan',
             'tanggal_pelepasan',
             'no_seri',
             'dokumen_pendukung',
             'kontainer',
             'biaya_perjalanan_dinas',
             'total_pnbp'
        );
    }

    /**
     *Digunakan mencetak semua table kh head pada masing2 class turunan
     *dan kemuadian masing2 child class mengoper ke view yang diperlukan
     * 
     * @return array
     */
    protected function tableTitleKh()
    {
        return array(
            'no',
            'bulan',
            'no_permohonan',
            'no_aju',
            'tanggal_permohonan',
            'jenis_permohonan',
            'nama_pemohon',
            'nama_pengirim',
            'alamat_pengirim',
            'nama_penerima',
            'alamat_penerima',
            'jumlah_kemasan',
            'kota_asal',
            'asal',
            'kota_tuju',
            'tujuan',
            'port_asal',
            'port_tuju',
            'moda_alat_angkut_terakhir',
            'tipe_alat_angkut_terakhir',
            'nama_alat_angkut_terakhir',
            'status_internal',
            'peruntukan',
            'jenis_mp',
            'kelas_mp',
            'kode_hs',
            'nama_mp',
            'nama_latin',
            'jumlah',
            'satuan',
            'jantan',
            'betina',
            'netto',
            'sat_netto',
            'bruto',
            'sat_bruto',
            'keterangan',
            'breed',
            'volumeP1',
            'nettoP1',
            'volumeP8',
            'nettoP8',
            'dok_pelepasan',
            'nomor_dok_pelepasan',
            'tanggal_pelepasan',
            'no_seri',
            'dokumen_pendukung',
            'kontainer',
            'biaya_perjalanan_dinas',
            'total_pnbp'
        );
    }
    /**
     *Digunakan untuk pengecekan wilker pada laporan excel 
     *Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    protected function checkUserWilker($path)
    {
        /*Get Format Laporan Untuk Domas*/
        $user_wilker = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

            config(['excel.import.startRow' => 1]);

        })->first()->toArray();

        /*Cek isi file kosong atau tidak*/
        if(in_array(null, $user_wilker)){

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
    protected function checkJenisKarantina($path, $jenis_karantina)
    {
        /*Get Format Laporan Untuk Dokel*/
        $tipe_karantina = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

            config(['excel.import.startRow' => 1]);

        })->first()->toArray();

        /*Cek isi file kosong atau tidak*/
        if(in_array(null, $tipe_karantina)){

            return 'not our format';

        }

        foreach ($tipe_karantina as $key => $value) {

            /*Cek dari value Kosong atau tidak*/
            if ($value == null || strpos($key, $jenis_karantina) === false) {

                return false;

            }

            /*Cek Jika File Yang Diunggah File KH */
            return strpos($key, $jenis_karantina) !== false ? true : false;
        }

    }

    /**
     *Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisPermohonan($path, $jenis_permohonan)
    {
        /*Get Format Laporan Untuk Dokel*/
        $tipe_permohonan = Excel::selectSheetsByIndex(0)->load($path, function($reader) {

            config(['excel.import.startRow' => 2]);

        })->first()->toArray();

        /*set here*/
        foreach ($tipe_permohonan as $tipe) {

            $lowereing  = strtolower($tipe);

            $getContent = explode(':', $lowereing);

            $tipe       = trim($getContent[1]);

        }

        /*Cek Jika File Yang Diunggah Domestik Keluar */

        return $tipe == $jenis_permohonan ?: false;
    }

    /**
     *Kompilasi Dari Method - method yang terdapat di class ini
     *sehingga kelas turunan cukup memanggil method ini saja untuk melakukan
     *semua pengecekan / kondisi
     *
     * @return bool
     */
    protected function checkingData($path, $jenis_karantina, $jenis_permohonan, $user)
    {
        /*Cek Format Laporan*/
        if ($this->checkJenisKarantina($path, $jenis_karantina) === 'not our format') {

            \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Merupakan Format Laporan Bulanan Dari IQFAST!');

            return false;
        }

        /*Cek Jenis Karantina*/
        if($this->checkJenisKarantina($path, $jenis_karantina) === false){

            \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Kegiatan ' . ucwords(str_replace('_', ' ', $jenis_karantina)).' !');

            return false;

        }

        /*Cek Jenis Permohonan*/
        if ($this->checkJenisPermohonan($path, $jenis_permohonan) === false) {

            \Session::flash('warning','Format Laporan Yang Anda Unggah Bukan Kegiatan ' . ucwords($jenis_permohonan) .' !');

            return false;

        }

        $wilker_laporan_clue = substr($this->checkUserWilker($path), -10, 8);

        /*Cek Wilker Dari User Yang Mengupload*/
        if(strpos($user, $wilker_laporan_clue) === false && Auth::user()->role_id != 1){

            \Session::flash('warning','Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!');

            return false;
        }

        return true;

    }

}

