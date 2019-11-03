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

class BaseOperasionalController extends Controller
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

        $this->linkNotify       =   route($this->typeKarantina .'.view.page.detail.bigtable.'. $this->model->alias,
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
=======
use App\Traits\UsersTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\ModelOperasionalInterface as Model;

ini_set('max_execution_time', '500');

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

        $this->wilkerName       = $this->cleanString( $this->getUserWilkerName((int) $request->wilker_id) );

        $this->wilkerUser       = $this->setUserWilker();

        $this->laporanPath      = $request->file('filenya')->getRealPath();

        $this->wilkerNameClue   = substr($this->checkUserWilker(), -10, 8);

        $this->jenisPermohonan  = strtolower($model->permohonan);

        $this->jenisKarantina   = strtolower(str_replace(' ', '_', $model->karantina));

        return $this;
    }

    /**
     * Digunakan untuk pengecekan wilker pada laporan excel 
     * Apakah sesuai atau tidak dengan wilker user yang mengupload 
     *
     * @return string
     */
    protected function checkUserWilker()
    {
        $key    = $this->getLaporanClue(1)->keys()->first();

        $value  = $this->getLaporanClue(1)->first();

        // Cek isi file kosong atau tidak
        if(strpos((string) $value, 'Karantina Pertanian') === false && 
           strpos($key, $this->jenisKarantina) === false ) return 'not our format';

        return $this->cleanString( trim(explode(":", $value)[2]) );
    }

    /**
     * Digunakan untuk pengecekan jenis karantina apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisKarantina()
    {
        $key    = $this->getLaporanClue(1)->keys()->first();

        $value  = $this->getLaporanClue(1)->first();

        // Cek isi file kosong atau tidak
        if(strpos((string) $value, 'Karantina Pertanian') === false && 
           strpos($key, $this->jenisKarantina) === false ) return 'not our format';

        // Cek dari value Kosong atau tidak
        if ($value == null || strpos($key, $this->jenisKarantina) === false) return false;

        // Cek Jika File Yang Diunggah Sudah Sesuai Dengan Jenis Karantinanya 
        return strpos($key, $this->jenisKarantina) !== false ? true : false;
    }

    /**
     * Digunakan untuk pengecekan jenis permohonan apakah sesuai 
     *
     * @return bool
     */
    protected function checkJenisPermohonan()
    {
        // Cek Jika File Yang Diunggah Sesuai Dengan Jenis Permohonannya 

        // Apabila laporan yang diupload merupakan pembatalan dokumen 
        // ambil data pada laporan yang diupload dimulai dari row ke 0
        if ($this->jenisPermohonan === 'pembatalan dokumen') {

            return  strpos(strtolower(

                        $this->getLaporanClue(0)->first()

                    ), $this->jenisPermohonan) !== false ? true : false;
            
        
        // Apabila laporan bukan merupakan pembatalan dokumen  
        // ambil data pada laporan yang diupload dimulai dari row ke 2
        } else {

            return  trim(explode(

                        ':', strtolower($this->getLaporanClue(2)->first())
                        
                    )[1])  == $this->jenisPermohonan ?: false;  

        }   
    }

    /**
     * Menghapus titik, spasi beserta koma pada string dan menjadikan string huruf kecil
     *
     * @param string $value
     * @return string
     */
    protected function cleanString(string $value)
    {   
        $value = str_replace('.', ' ', $value);

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
        return  excel()->selectSheetsByIndex(0)
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
        // Cek Format Laporan
        if ($this->checkJenisKarantina() === 'not our format') {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Merupakan Format 
                                  Laporan Bulanan Dari IQFAST!";

            $this->flashMessage();

            return false;
        }

        // Cek Jenis Karantina
        if(! $this->checkJenisKarantina()) {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Kegiatan "
                                  .ucwords(str_replace('_', ' ', $this->jenisKarantina)) ." !";

            $this->flashMessage();

            return false;

        }

        // Cek Jenis Permohonan
        if (! $this->checkJenisPermohonan()) {

            $this->messageType  = "warning";

            $this->message      = "Format Laporan Yang Anda Unggah Bukan Kegiatan " 
                                  .ucwords($this->jenisPermohonan). " !";

            $this->flashMessage();

            return false;

        }
        
        // Cek Wilker User dengan wilker yang diupload pada laporan, 
        // harus sesuai kecuali wilker brangbiji
        // Note : Wilker Pada IQFAST -> Brangbiji, Pada E - Office -> Sultan M. Kaharuddin
        if ($this->getUserRoleId() !== 1 && 
            $this->getUserRoleId() !== 2 && 
            strpos($this->checkUserWilker(), 'brangbiji') === false) {

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

>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
}

