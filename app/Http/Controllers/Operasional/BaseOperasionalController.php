<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\ModelOperasionalInterface as Model;

ini_set('max_execution_time', '200');

class BaseOperasionalController extends Controller
{
    use UsersTrait;

    /**
     * Untuk menyimpan nama table dari model yang dipakai
     *
     * @var string
     */
    private $tableName;

    /**
     * Untuk menyimpan user ID User
     *
     * @var int | bool
     */
    private $userId; 

    /**
     * Untuk menyimpan Wilker User
     *
     * @var array
     */
    private $wilkerUser = []; 

    /**
     * Untuk menyimpan Nama Wilker User
     *
     * @var string
     */
    private $wilkerName;

    /**
     * Untuk menyimpan Nama Wilker User sebagai clue untuk pengujian
     *
     * @var string
     */
    private $wilkerNameClue; 

    /**
     * Untuk menyimpan jenis permohonan karantina
     *
     * @var string
     */
    private $jenisPermohonan;

    /**
     * Untuk menyimpan jenis karantina
     *
     * @var string
     */
    private $jenisKarantina;

    /**
     * Untuk menyimpan temporary path dari file yang diupload
     *
     * @var string
     */
    private $laporanPath;

    /**
     * Untuk menyimpan isi message
     *
     * @var string
     */
    protected $message;

    /**
     * Untuk menyimpan type message
     *
     * @var string
     */
    protected $messageType;

    /**
     * Set data property untuk diolah lebih lanjut
     *
     * @param Request $request, Model $model
     * @return string
     */
    protected function setDataProperty(Request $request, Model $model)
    {
        $this->tableName        = $model->getTable();

        $this->userId           = $this->checkActiveUserIdAndRequestUserId((int) $request->user_id);

        $this->wilkerId         = $this->setUserWilkerId((int) $request->wilker_id);

        $this->wilkerName       = $this->cleanString( $this->getUserWilkerName((int) $request->wilker_id) );

        $this->wilkerUser       = $this->setUserWilker();

        $this->laporanPath      = $request->file('filenya')->getRealPath();

        $this->wilkerNameClue   = substr($this->checkUserWilker(), -10, 8);

        $this->jenisPermohonan  = $model->permohonan;

        $this->jenisKarantina   = 'operasional_' . strtolower(str_replace(' ', '_', $model->karantina));
    }

    /**
     * Digunakan untuk pengecekan wilker pada laporan excel 
     * Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    protected function checkUserWilker()
    {
        /*Cek isi file kosong atau tidak*/
        if(strpos($this->getLaporanClue(1)->first(), 'Karantina Pertanian') === false &&
           strpos($this->getLaporanClue(1)->keys()->first(), 'laporan_kegiatan_operasional') === false
        ) return 'not our format';

        return $this->cleanString( trim(explode(":", $this->getLaporanClue(1)->first())[2]) );
    }

    /**
     * Digunakan untuk pengecekan jenis karantina apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisKarantina()
    {
        /*Cek isi file kosong atau tidak*/
        if(strpos($this->getLaporanClue(1)->first(), 'Karantina Pertanian') === false &&
           strpos($this->getLaporanClue(1)->keys()->first(), 'laporan_kegiatan_operasional') === false
        ) return 'not our format';

        $key    = $this->getLaporanClue(1)->keys()->first();

        $value  = $this->getLaporanClue(1)->first();

        /*Cek dari value Kosong atau tidak*/
        if ($value == null || strpos($key, $this->jenisKarantina) === false) return false;

        /*Cek Jika File Yang Diunggah Sudah Sesuai Dengan Jenis Karantinanya */
        return strpos($key, $this->jenisKarantina) !== false ? true : false;

    }

    /**
     * Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisPermohonan()
    {
        /*Cek Jika File Yang Diunggah Sesuai Dengan Jenis Permohonannya */

        return  trim(explode(

                    ':', strtolower($this->getLaporanClue(2)->first())
                    
                )[1])  == $this->jenisPermohonan ?: false;   
    }

    /**
     * Menghapus titik beserta koma pada string
     *
     * @param string $value
     * @return string
     */
    protected function cleanString(string $value)
    {   
        if (strpos($value, '.') !== false) $value = str_replace('.', ' ', $value);

        return strtolower(trim(str_replace(' ', '', $value)));
    }

    /**
     * Mengambil data dari laporan yang diupload sesuai row yang diinginkan
     *
     * @param int $row
     * @return array
     */
    protected function getLaporanClue(int $row)
    {
        return  Excel::selectSheetsByIndex(0)
                ->load($this->laporanPath, function($reader) use ($row) {

                    config(['excel.import.startRow' => $row]);

                })->first();
    }

    /**
     * Kompilasi Dari Method - method yang terdapat di class ini
     * sehingga kelas turunan cukup memanggil method ini saja untuk melakukan
     * semua pengecekan / kondisi
     *
     * @return bool
     */
    protected function checkingData()
    {   
        /*Cek Format Laporan*/
        if ($this->checkJenisKarantina() === 'not our format') {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Merupakan Format 
                                  Laporan Bulanan Dari IQFAST!";

            $this->flashMessage();

            return false;
        }

        /*Cek Jenis Karantina*/
        if(! $this->checkJenisKarantina()) {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Kegiatan "
                                  . ucwords(str_replace('_', ' ', $this->jenisKarantina)) ." !";

            $this->flashMessage();

            return false;

        }

        /*Cek Jenis Permohonan*/
        if (! $this->checkJenisPermohonan()) {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Kegiatan " 
                                  .ucwords($this->jenisPermohonan). " !";

            $this->flashMessage();

            return false;

        }

        /*Cek Wilker User dengan wilker yang diupload pada laporan, harus sesuai*/
        if ($this->getUserRoleId() !== 1 && $this->getUserRoleId() !== 2) {

            if(! strpos(strtolower($this->wilkerName), $this->wilkerNameClue)){

                $this->messageType  = "warning";

                $this->message      = "Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!";

                $this->flashMessage();

                return false;
            }

            if(! strpos($this->wilkerUser[0], $this->wilkerNameClue) &&
               ! strpos($this->wilkerUser[1], $this->wilkerNameClue) ){

                $this->messageType  = "warning";

                $this->message      = "Laporan Yang Anda Unggah Tidak Sesuai Dengan Wilker Anda!";

                $this->flashMessage();

                return false;
            }

        }
        
        return true;

    }

    /**
     * Digunakan untuk flash session message 
     *
     * @return session flash
     */
    protected function flashMessage()
    {
        return session()->flash("$this->messageType", "$this->message");
    }

    /**
     * Digunakan URL request kemudian di redirect ke table detail laporan
     *
     * @param Request $request
     * @return void
     */
    protected function DetailTableSelectAnotherYear(Request $request)
    {
        return redirect($request->year);
    }

}

