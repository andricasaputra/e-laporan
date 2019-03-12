<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\ModelReportBillingInterface as Model;

class BaseReportBillingController extends Controller
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
     * Untuk menyimpan jenis permohonan karantina
     *
     * @var string
     */
    private $jenisPermohonan;

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
     * Method ini dipanggil pada kelas turunan untuk set property
     * dan dapat digunakan pada kelas turunan lainnya
     *
     * @param Request $request, Model $model
     * @return string
     */
    protected function setDataProperty(Request $request, Model $model)
    {
        $this->tableName        = $model->getTable();

        $this->userId           = $this->checkActiveUserIdAndRequestUserId((int) $request->user_id);

        $this->wilkerId         = $this->setUserWilkerId((int) $request->wilker_id);

        $this->wilkerName       = clean_string( $this->getUserWilkerName((int) $request->wilker_id) );

        $this->wilkerUser       = $this->setUserWilker();

        $this->laporanPath      = $request->file('filenya')->getRealPath();

        $this->jenisPermohonan  = strtolower($model->permohonan);

        return $this;
    }

    /**
     * Digunakan untuk pengecekan format file excel
     *
     * @return bool|string
     */
    protected function checkValidExcelFile()
    {
    	// Cek isi file kosong adalah laporan billing
    	if ($this->getLaporanClue(0)->first() !== 'LAPORAN BILLING') return false;

    	// Cek isi file kosong atau tidak
    	if ($this->getLaporanClue(6) === null) return 'nihil';

        return true;  
    }

    /**
     * Digunakan untuk pengecekan wilker pada laporan excel 
     * Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    protected function checkUserWilker()
    {
        $getWilker  = clean_string( $this->getLaporanClue(6)['wilker'] );

       	return $this->wilkerName == $getWilker ? $getWilker : 'not same wilker';
    }

    /**
     * Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisPermohonan()
    {
        // Cek Jika File Yang Diunggah Sesuai Dengan Jenis Permohonannya
        if ($this->jenisPermohonan !== 'setor billing') return false;

        return true;  
    }

    /**
     * Mengambil data dari laporan yang diupload sesuai row yang diinginkan
     *
     * @param int $row
     * @return array
     */
    protected function getLaporanClue(int $row)
    {
        return  excel()->load($this->laporanPath, function($reader) use ($row) {

                    config(['excel.import.startRow' => $row]);

                    return $reader->get();

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
        // Cek Jenis Permohonan
        if (! $this->checkJenisPermohonan()) {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Kegiatan " 
                                  .ucwords($this->jenisPermohonan). " !";

            $this->flashMessage();

            return false;

        }

        // Cek Laporan Excel Tidak Rusak
        if($this->checkValidExcelFile() === false){

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Tidak Sesuai, Mohon Periksa Kembali!";

            $this->flashMessage();

            return false;
        }

        // Cek Laporan Excel Tidak Rusak
        if($this->checkValidExcelFile() === 'nihil'){

            $this->messageType  = "warning";

            $this->message      = "Laporan Yang Nihil Tidak Perlu Untuk Diunggah :)";

            $this->flashMessage();

            return false;
        }

        // Cek Wilker User dengan wilker yang diupload pada laporan, 
        // harus sesuai kecuali wilker brangbiji
        // Note : Wilker Pada IQFAST -> Brangbiji, Pada E - Office -> Sultan M. Kaharuddin
        if ($this->getUserRoleId() !== 1 && 
            $this->getUserRoleId() !== 2 && 
            strpos($this->checkUserWilker(), 'brangbiji') === false) {

            if($this->checkUserWilker() === 'not same wilker'){

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
}
