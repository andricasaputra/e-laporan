<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\User;
use App\Models\Wilker;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\DataOperasionalUploadedEvent;
use App\Contracts\ModelOperasionalInterface as Model;
use App\Http\Controllers\TanggalController as Tanggal;
use App\Http\Requests\UploadOperasionalRequest as Request;

class UploadPembatalanController extends BaseOperasionalController
{
    /**
     * Untuk menyimpan model instance
     *
     * @var Object App\Models\..
     */
	private $model;

    /**
     * Untuk menyimpan request
     *
     * @var Request 
     */
    private $request;

    /**
     * Untuk menyimpan path dari file yang diupload
     *
     * @var string 
     */
    private $path;

    /**
     * Untuk menyimpan type karantina
     *
     * @var string 
     */
    private $type_karantina;

    /**
     * Untuk menyimpan isi data laporan yang diupload
     *
     * @var array 
     */
    private $datas = [];

    /**
     * Untuk menyimpan isi heading laporan yang diupload
     *
     * @var array 
     */
    private $headings = [];

    /**
     * Untuk menyimpan type success
     *
     * @var int 
     */
    private $success = 0;

    /**
     * Untuk menyimpan tanggal dari laporan
     *
     * @var date d-m-Y 
     */
    public  $tanggal;

    /**
     * Untuk menyimpan table dari model yang dipakai
     *
     * @var string 
     */
    public  $table;

    /**
     * Untuk menyimpan wilker dan digunakan sebagai notifikasi 
     *
     * @var array|collections 
     */
    public  $wilker;

    /**
     * Untuk menyimpan user-user yang akan dinotifikasi
     *
     * @var array|collections 
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
     * Set kebutuhan upload property
     *
     * @param App\Models\Model.. $model
     * @param Request $request
     * @return void
     */
    public function __construct(Model $model, Request $request)
    {
    	$this->model 			= $model;

        $this->table            = $model->getTable();

    	$this->request 			= $request;

    	$this->path 			= $request->file('filenya')->getRealPath();

    	$this->type_karantina   = explode('_', $model->getTable());

        $this->type_karantina   = end($this->type_karantina);

        return $this;
    }

    /**
     * Method utama untuk upload file 
     *
     * @return void
     */
    public function uploadData()
    {
    	/*Ambil Bulan Dan Tahun Pada Laporan Di Row 3*/
        $this->headings	= 	$this->excelData(3)->first();

        /*Data Asli Dimulai Dari Row Ke 7*/
        $this->datas 	= 	$this->excelData(7, false)->get();

        /*set tanggal format Y-m-d*/
        $tanggal 	    = explode(' ', strtolower($this->headings->first()));

        $this->tanggal  = $tanggal[2];

    	/*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
        if (! empty($this->datas) && $this->datas->count() > 0) :

    		/*Run Upload Proccess*/
            $this->uploadProccess(); 

        /*File laporan yang diupload benar tetapi data nihil*/
        else:

            /*Run Upload Proccess*/
            $this->uploadProccessNihil();

        endif;

        /*berikan feedback pesan kepada user setelah upload laporan*/
        return $this->setMessageType()->flashMessage();
    }

    /**
     * Ambil Data Dari Laporan Excel Yang Diupload
     *
     * @param int $startrow
     * @param bool $ignoreEmpty
     * @return Excel Collection
     */
    public function excelData($startRow, $ignoreEmpty = true)
    {
        return  Excel::selectSheetsByIndex(0)
                ->load($this->path, function($reader) use ($startRow, $ignoreEmpty) {

                    config(['excel.import.startRow' => $startRow]);

                    return $reader->ignoreEmpty($ignoreEmpty);

                });
    }

    /**
     * Method delegasi dari uploadData(), proses upload yang file laporannya tidak nihil dilakukan di method ini 
     * Juga berfungsi sebagai notifikasi setter
     *
     * @return void
     */
    private function uploadProccess()
    {
        /*Set kebutuhan data untuk insert / update*/
    	$datas = $this->datas->map(function($singledata){

           return $singledata->prepend($this->request->wilker_id, 'wilker_id')
                             ->prepend($this->request->user_id, 'user_id')
                             ->prepend($this->tanggal, 'bulan')
                             ->put('created_at', \Carbon::now())
                             ->all();

        });



        /*Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum, jika sudah lakukan update, jika belum insert baru*/
        $no_permohonan      = $datas->whereNotIn('no_permohonan', ['IDEM'])
                                    ->pluck('no_permohonan')
                                    ->all();

        $forinsertOrUpdate  = $this->model::select('no_permohonan')
                                   ->whereNotIn('no_permohonan', ['IDEM'])
                                   ->whereIn('no_permohonan', $no_permohonan)
                                   ->get();

        /*Jika Data Kosong artinya laporan belum pernah diupload -> maka insert*/                           
        if ($forinsertOrUpdate === null || count($forinsertOrUpdate) === 0) {

            $insertOrUpdate = $this->model->insert( $datas->all() ); 

        /*Laporan sudah pernah diupload -> maka update laporan*/
        } else {

            foreach ($datas as $key => $value) {

               $this->model->whereNotIn('no_permohonan', ['IDEM'])
                           ->where('no_permohonan', $value['no_permohonan'])
                           ->where('wilker_id', $value['wilker_id'])
                           ->update($value);

            }

            $insertOrUpdate = false;

        }

        /*Set success untuk menampilkan pesan kepada user setelah upload*/
        $insertOrUpdate === true ? $this->success = 1 : $this->success = 2;

        /*Kirim notifikasi kepada user setelah upload*/
        if ($insertOrUpdate) {

            /*Set Notifications Properties*/
            $this->setNotificationsProperties((int) $this->request->wilker_id);

            /*Call Event to Notify*/
            $this->eventNotifyHandler();
            
        }

    }

    /**
     * Method delegasi dari uploadData(), proses upload yang file laporannya nihil dilakukan di method ini 
     * Juga berfungsi sebagai notifikasi setter
     *
     * @return void
     */
    private function uploadProccessNihil()
    {
        $wilker_id   = $this->setUserWilkerId((int) $this->request->wilker_id);
        $user_id     = $this->checkActiveUserIdAndRequestUserId((int) $this->request->user_id);
        $bulan       = $this->tanggal;

        $this->model::updateOrCreate(
            [ 
                'wilker_id' =>  $wilker_id, 
                'bulan' => $bulan
            ], 
            [
                'wilker_id' =>  $wilker_id, 
                'user_id' => $user_id,
                'bulan' => $bulan
            ] 
        );

        $this->success = 1;

        /*Set Notifications Properties*/
        $this->setNotificationsProperties((int) $this->request->wilker_id);

        /*Call Event to Notify*/
        $this->eventNotifyHandler();
    }

    /**
     * Set tipe pesan sesuai hasil upload laporan
     *
     * @return void
     */
    private function setMessageType()
    {
        switch ($this->success) :

            case 1:

                $this->messageType = 'success';
                $this->message = 'Data Berhasil Diimport!';
                break;

            case 2:

                $this->messageType = 'success';
                $this->message = 'Data Berhasil Diperbarui!'; 
                break;

            case -1:

                $this->messageType = 'warning';
                $this->message = 'Ketidaksesuaian data antara Dokumen Sertifikat dan Total PNBP ditemukan!, Total PNBP Tidak Boleh 0 pada Dokumen Sertifikat Yang dipakai';
                break;

            default:
                $this->messageType = 'warning';
                $this->message = 'Gagal Import Data!';
                break;

        endswitch;

        return $this;
    }

    /**
     * Jika laporan berhasil diupload, method ini bertugas untuk mengatur kebutuhan pesan
     * notifikasi
     *
     * @param int $wilker_id
     * @return void
     */
    private function setNotificationsProperties(int $wilker_id)
    {
        $this->wilker           =   Wilker::find($wilker_id);

        $this->usersToNotify    =   User::whereIn('id', [1, 2, 3, 4, 5])->get();

        $this->linkNotify       =   $this->type_karantina === 'kt' 
                                    ? route('kt.view.page.detail.dokumen.'. $this->model->alias)
                                    : route('kh.view.page.detail.dokumen.'. $this->model->alias);

        $this->notifyMessage    =   "Laporan 
                                    {$this->request->jenis_permohonan} 
                                    {$this->model->karantina} 
                                    {$this->wilker->nama_wilker} Bulan 
                                    " .Tanggal::bulan( (int) date('m', strtotime($this->tanggal)) ). " 
                                    Sudah Terikirim";
    }

    /**
     * Eksekutor notifikasi
     *
     * @return void
     */
    private function eventNotifyHandler()
    {
       new DataOperasionalUploadedEvent( $this );
    }
}
