<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\User;
use App\Models\Wilker;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Traits\TableOperasionalProperty;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Operasional\ModelOperasionalInterface;

ini_set('max_execution_time', '200');

class BaseOperasional extends Controller
{
    use UsersTrait, TableOperasionalProperty;

    private $tableName;
    private $userId; 
    private $wilkerUser = []; 
    private $wilkerName;
    private $wilkerNameClue; 
    private $jenisPermohonan;
    private $jenisKarantina;
    private $laporanPath;
    protected $message;
    protected $messageType;

    /**
     *Set data property untuk diolah lebih lanjut
     *
     * @return string
     */
    protected function setDataProperty(Request $request, ModelOperasionalInterface $model)
    {

        $this->tableName        = $model->getTable();

        $this->userId           = $this->checkActiveUserIdAndRequestUserId((int) $request->user_id);

        $this->wilkerId         = $this->setUserWilkerId((int) $request->wilker_id);

        $this->wilkerName       = $this->cleanWilkerString($this->getUserWilkerName((int) $request->wilker_id));

        $this->wilkerUser       = $this->setUserWilker();

        $this->laporanPath      = $request->file('filenya')->getRealPath();

        $this->wilkerNameClue   = substr($this->checkUserWilker(), -10, 8);

        $this->getJenisPermohonan();

    }

    /**
     *Set jenis permohonan & karantina berdasarkan model yang masuk pada setDataProperty()
     *
     * @return string
     */
    protected function getJenisPermohonan()
    {
        switch ($this->tableName) :

            case 'dokel_kt':
                $this->jenisPermohonan = 'domestik keluar';
                $this->jenisKarantina  = 'operasional_karantina_tumbuhan';
                break;
            case 'domas_kt':
                $this->jenisPermohonan = 'domestik masuk';
                $this->jenisKarantina  = 'operasional_karantina_tumbuhan';
                break;
            case 'ekspor_kt':
                $this->jenisPermohonan = 'ekspor';
                $this->jenisKarantina  = 'operasional_karantina_tumbuhan';
                break;
            case 'impor_kt':
                $this->jenisPermohonan = 'impor';
                $this->jenisKarantina  = 'operasional_karantina_tumbuhan';
                break;
            case 'dokel_kh':
                $this->jenisPermohonan = 'domestik keluar';
                $this->jenisKarantina  = 'operasional_karantina_hewan';
                break;
            case 'domas_kh':
                $this->jenisPermohonan = 'domestik masuk';
                $this->jenisKarantina  = 'operasional_karantina_hewan';
                break;
            case 'ekspor_kh':
                $this->jenisPermohonan = 'ekspor';
                $this->jenisKarantina  = 'operasional_karantina_hewan';
                break;
            case 'impor_kh':
                $this->jenisPermohonan = 'impor';
                $this->jenisKarantina  = 'operasional_karantina_hewan';
                break;
            default:
                $this->jenisPermohonan = 'Data Operasional Tidak Ditemukan';
                $this->jenisKarantina  = 'No Clue';
                break;
            
        endswitch;

    }

    /**
     *Digunakan untuk pengecekan wilker pada laporan excel 
     *Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    protected function checkUserWilker() : string
    {
        /*Cek isi file kosong atau tidak*/
        if(in_array(null, $this->getLaporanClue(1))){

            return 'not our format';

        }

        foreach ($this->getLaporanClue(1) as $key => $value) {

            /*Get Wilker By Dokumen Yang Diupload*/

            $x      = explode(":", $value);

            $wilker = trim($x[2]);

            return $this->cleanWilkerString($wilker);
            
        }

    }

    /**
     *Digunakan untuk pengecekan jenis karantina apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisKarantina() : bool
    {
        /*Cek isi file kosong atau tidak*/
        if(in_array(null, $this->getLaporanClue(1))){

            return false;

        }

        foreach ($this->getLaporanClue(1) as $key => $value) {

            /*Cek dari value Kosong atau tidak*/
            if ($value == null || strpos($key, $this->jenisKarantina) === false) {

                return false;

            }

            /*Cek Jika File Yang Diunggah File KH */
            return strpos($key, $this->jenisKarantina) !== false ? true : false;
        }

    }

    /**
     *Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisPermohonan()
    {
        /*set here*/
        foreach ($this->getLaporanClue(2) as $tipe) :

            $lowereing  = strtolower($tipe);

            $getContent = explode(':', $lowereing);

            $tipe       = trim($getContent[1]);

        endforeach;

        /*Cek Jika File Yang Diunggah Domestik Keluar */

        return $tipe == $this->jenisPermohonan ?: false;
    }

    /**
     *Menghapus titik beserta koma pada string
     *
     * @return string
     */
    protected function cleanWilkerString(string $value) : string
    {   
        if (strpos($value, '.') !== false) {

            $value = str_replace('.', ' ', $value);
        }   

        $value = str_replace(' ', '', $value);
        
        return strtolower(trim($value));
    }

    /**
     *Mengambil data dari laporan yang diupload sesuai row yang diinginkan
     *
     * @return array
     */
    protected function getLaporanClue(int $row) : array
    {
        return  Excel::selectSheetsByIndex(0)->load($this->laporanPath, function($reader) use ($row) {

                    config(['excel.import.startRow' => $row]);

                })->first()->toArray();
    }

    /**
     *Kompilasi Dari Method - method yang terdapat di class ini
     *sehingga kelas turunan cukup memanggil method ini saja untuk melakukan
     *semua pengecekan / kondisi
     *
     * @return bool
     */
    protected function checkingData() : bool
    {
        /*Cek Format Laporan*/
        if ($this->checkJenisKarantina() === 'not our format') {

            $this->messageType = "warning";

            $this->message = "Format Laporan Yang Anda Unggah Bukan Merupakan Format Laporan Bulanan Dari IQFAST!";

            $this->flashMessage();

            return false;
        }

        /*Cek Jenis Karantina*/
        if($this->checkJenisKarantina() === false) {

            $this->messageType = "warning";

            $this->message = "Format Laporan Yang Anda Unggah Bukan Kegiatan ". ucwords(str_replace('_', ' ', $this->jenisKarantina)) ." !";

            $this->flashMessage();

            return false;

        }

        /*Cek Jenis Permohonan*/
        if ($this->checkJenisPermohonan() === false) {

            $this->messageType = "warning";

            $this->message = "Format Laporan Yang Anda Unggah Bukan Kegiatan" .ucwords($this->jenisPermohonan). " !";

            $this->flashMessage();

            return false;

        }

        /*Cek Wilker User dengan wilker yang diupload pada laporan, harus sesuai*/
        if ($this->getUserRoleId() !== 1 && $this->getUserRoleId() !== 2) {

            if(strpos(strtolower($this->wilkerName), $this->wilkerNameClue) === false){

                $this->messageType = "warning";

                $this->message = "Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!";

                $this->flashMessage();

                return false;
            }

            if( strpos($this->wilkerUser[0], $this->wilkerNameClue) === false &&
                strpos($this->wilkerUser[1], $this->wilkerNameClue) === false ){

                $this->messageType = "warning";

                $this->message = "Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!";

                $this->flashMessage();

                return false;
            }

        }
        
        return true;

    }

    /*set flash message*/
    protected function flashMessage() : ?Session
    {
        return Session::flash("$this->messageType", "$this->message");
    }

    /*Menangkap URL Request Kemudian Di Redirect*/
    protected function selectAnotherYear(Request $request)
    {
        return redirect($request->year);
    }

}

