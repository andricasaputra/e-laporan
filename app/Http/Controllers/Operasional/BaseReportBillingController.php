<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

<<<<<<< HEAD
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wilker;
use App\Http\Controllers\Controller;
use App\Events\DataOperasionalUploadedEvent;
use App\Imports\Operasional\Factories\ImportFactory;
use App\Imports\Operasional\Factories\BeforeImportFactory;

class BaseReportBillingController extends Controller
{
    /**
     * Untuk menyimpan model instance
     *
     * @var App\Contracts\ModelOperasionalInterface 
     */
    protected $model;

    /**
     * Untuk menyimpan request
     *
     * @var Illuminate\Http\Request 
     */
    protected $request;

    /**
     * Untuk menyimpan pesan kesalahan apabila gagal import
     *
     * @var string
     */
    protected $warning;

    /**
     * Untuk menyimpan type karantina
     *
     * @var string 
     */
    protected $typeKarantina;

    /**
     * Untuk menyimpan nama table yang akan digunakan
     * untuk keperluan notifikasi
     *
     * @var string 
     */
    public $table;

    /**
     * Untuk menyimpan tanggal dari laporan
     *
     * @var string 
     */
    public  $tanggal;

    /**
     * Untuk menyimpan wilker dan digunakan sebagai notifikasi 
     *
     * @var array 
     */
    public  $wilker;

    /**
     * Untuk menyimpan user-user yang akan dinotifikasi
     *
     * @var array 
     */
    public  $usersToNotify;

    /**
     * Untuk menyimpan pesan notifikasi
     *
     * @var string 
     */
    public  $notifyMessage;

    /**
     * Untuk menyimpan link notifikasi
     *
     * @var string 
     */
    public  $linkNotify;

    /**
     * Untuk menangkap hasil validasi dari class 
     * App\Imports\Operasional\BeforeImportOperasional
     *
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    protected function validateLaporan($model, $request) : bool
    {
        $this->request     = $request;

        // instansiasi factory untuk mendapatkan object mana yang akan dipakai
        $validationFactory = new BeforeImportFactory();

        // inisiasi untuk mendapatkan class yang akan melakukan validasi
        $fileValidation    = $validationFactory->initializeValidationType($model, $this->request);

        // Kemudian set beberapa properti untuk keperluan validasi data laporan
        $fileValidation->setValidationProperties();

        // Setelah semua properti siap kita jalankan validasi 
        // dan berikan feedback kepada user apabila ada kesalahan upload
        if(! $fileValidation->runValidation()) {

            $this->warning = $fileValidation->getWarning();
=======
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
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

            return false;

        }

<<<<<<< HEAD
        // Apabila berhasil validasi kita ambil tanggal 
        // laporan untuk keperluan import data dan notifikasi
        // tanggal laporan berada pada bagian header laporan 
        // sehingga dikirim dari data file yang kita validasi
        $this->tanggal = $fileValidation->getTanggalLaporan();

        return true;
    }

    /**
     * Untuk menjalankan proses import data ke database 
     * dan beri notifikasi apabila data belum pernah diupload
     *
     * @param App\Contracts\ModelOperasionalInterface 
     * @return void
     */
    protected function runImportProcess($model)
    {
        $this->model = $model;

        $factory     = new ImportFactory();

        $imports     = $factory->initializeImportsType($model, $this->request, $this->tanggal);

        excel()->import($imports, $this->request->file('filenya'));

        // Beri notifikasi kepada user apabila berhasil imports
        if ($imports->notificationTrigger()) {

            $this->setNotificationProperties()->fireUploadEvent();

        }
    }

    /**
     * Jika laporan berhasil diupload, method ini bertugas untuk
     * mengatur kebutuhan pesan notifikasi
     *
     * @return void
     */
    public function setNotificationProperties()
    {
        $this->table            =   $this->model->getTable();

        $this->wilker           =   Wilker::find($this->request->wilker_id);

        $this->usersToNotify    =   User::whereIn('id', [1, 2, 3, 4, 5])->get();

        $this->typeKarantina    =   explode('_', $this->table);

        $this->typeKarantina    =   end($this->typeKarantina);

        $this->linkNotify       =   route($this->typeKarantina .'.view.page.detail.pnbp.'. $this->model->alias,
                                       [
                                        Carbon::parse($this->tanggal)->format('Y'),
                                        Carbon::parse($this->tanggal)->format('m'),
                                        $this->request->wilker_id
                                       ]
                                    );

        $this->notifyMessage    =   "Laporan {$this->request->jenis_permohonan} 
                                    {$this->model->karantina} {$this->wilker->getOriginal('nama_wilker')} 
                                    Bulan ". bulan(Carbon::parse($this->tanggal)->format('m')) ." 
                                    Sudah Terikirim";

        return $this;
    }

    /**
     * Jalankan event notifikasi
     *
     * @return void
     */
    public function fireUploadEvent()
    {
        new DataOperasionalUploadedEvent($this);
    }
}

=======
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
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
