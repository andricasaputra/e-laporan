<?php  

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Imports\Operasional\Factories\ImportFactory;
use App\Imports\Operasional\Factories\BeforeImportFactory;

abstract class AbstractBaseOperasional extends Controller
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
     * @param App\Contracts\ModelOperasionalInterface|ModelPembatalanInterface|ModelReportBillingInterface $model
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    protected function validateLaporan($model, $request) : bool
    {
        $this->request     = $request;

        // instansiasi factory untuk mendapatkan object mana yang akan dipakai
        $validationFactory = new BeforeImportFactory();

        // inisiasi untuk mendapatkan class yang akan melakukan validasi
        // dan kirim data ke constructor class validasi yang dipakai
        $fileValidation    = $validationFactory->initializeValidationType($model, $this->request);

        // Kemudian set beberapa properti untuk keperluan validasi data laporan
        $fileValidation->setValidationProperties();

        // Setelah semua properti siap kita jalankan validasi 
        // dan berikan feedback kepada user apabila ada kesalahan upload
        if(! $fileValidation->runValidation()) {

            $this->warning = $fileValidation->getWarning();

            return false;

        }

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
     * @param App\Contracts\ModelOperasionalInterface|ModelPembatalanInterface|ModelReportBillingInterface $model
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

    abstract public function setNotificationProperties();

    abstract public function fireUploadEvent();
}