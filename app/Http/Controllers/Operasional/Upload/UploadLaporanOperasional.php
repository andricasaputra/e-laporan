<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Upload;

use App\Models\User;
use App\Models\Wilker;
use Mavinoo\LaravelBatch\Batch;
use App\Events\DataOperasionalUploadedEvent;
use App\Contracts\ModelOperasionalInterface as Model;
use App\Http\Requests\UploadOperasionalRequest as Request;
use App\Http\Controllers\Operasional\Upload\UploaderInterface;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class UploadLaporanOperasional extends BaseOperasionalController implements UploaderInterface
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
     * Untuk menyimpan tipe dokumen  - dokumen dari KT yang mempunyai tarif PNBP
     *
     * @var array 
     */
    private $dokumenKt = ['KT9', 'KT10', 'KT12'];

    /**
     *Untuk menyimpan tipe dokumen  - dokumen dari KH yang mempunyai tarif PNBP
     *
     * @var array 
     */
    private $dokumenKh = ['KH11', 'KH12', 'KH13', 'KH14'];

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
     * Untuk menyimpan kolom index dari table
     *
     * @var string 
     */
    public  $index = 'no_permohonan';

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
    }

    /**
     * Method utama untuk upload file 
     *
     * @return void
     */
    public function uploadData()
    {
    	// Ambil Bulan Dan Tahun Pada Laporan Di Row 3
        $this->headings	= 	$this->excelData(3)->first();

        // Data Asli Dimulai Dari Row Ke 7
        $this->datas 	= 	$this->excelData(7, false)->get();

        // set tanggal format Y-m-d
        $tanggal 	    = explode(' ', strtolower($this->headings->first()));
        $bulan      	= $tanggal[2];
        $tahun      	= $tanggal[6];
        $this->tanggal 	= "{$tahun}-{$bulan}-01";

    	// Jika semua validasi berhasil & jika file tidak kosong maka insert ke database
        if (! empty($this->datas) && $this->datas->count() > 0) :

    		// Run Upload Proccess
            $this->uploadProccess(); 

        // File laporan yang diupload benar tetapi data nihil
        else:

            // Run Upload Proccess
            $this->uploadProccessNihil();

        endif;

        // berikan feedback pesan kepada user setelah upload laporan
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
        return  excel()->selectSheetsByIndex(0)
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
        // Set kebutuhan data untuk insert / update
    	$datas = $this->datas->map(function($singledata){

           return $singledata->prepend($this->request->wilker_id, 'wilker_id')
                             ->prepend($this->request->user_id, 'user_id')
                             ->prepend($this->tanggal, 'bulan')
                             ->put('created_at', now())
                             ->put('no_kwitansi', $this->buildNoKwitansi($singledata) )
                             ->all();

        });
      
        // Pengecekan PNBP yang tidak boleh 0 pada dokumen pelepasan yang dikenakan tarif
        if (! $this->checkPnbp($datas)) return false;
 
        // Jika Laporan belum pernah diupload, maka insert 
        $datas->when((int) $this->forInsertOrUpdate($datas) === 0, function ($datas) {

            $this->model->insert( $datas->all() ); 

            $this->success = 1;

            // Kirim notifikasi kepada user setelah upload
            $this->setNotificationsProperties((int) $this->request->wilker_id);

            // Call Event to Notify
            $this->eventNotifyHandler();

        }, function($datas){

            (new Batch)->update($this->table, $datas, $this->index);

            $this->success = 2;

        });                         

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

        $insertOrUpdate = $this->model::updateOrCreate(
            [ 
                'wilker_id' =>  $wilker_id, 
                'bulan' => $bulan
            ], 
            [
                'user_id' => $user_id,
            ] 
        );

        $this->success = 1;

        // Set Notifications Properties
        $this->setNotificationsProperties((int) $this->request->wilker_id);

        // Call Event to Notify
        $this->eventNotifyHandler();
    }

    /**
     * Digunakan untuk pengecekan tarif pnbp pada laporan yang diupload
     * untuk kasus tarif 0 pada permohonan yang seharusnya terdapat 
     * jasa karantina, biasanya kesalahan dalam export laporan pada IQFAST
     *
     * @param array $datas
     * @return bool
     */
    private function checkPnbp($datas)
    {
        // Pengecekan PNBP Berdasarkan Type Karantina & Dokumen Pelepasan
        if ($this->type_karantina === 'kt') {

            $cekPnbp = $datas->whereIn('dok_pelepasan', $this->dokumenKt)
                             ->where('total_pnbp', 0.0)
                             ->first();

        } else {

            $cekPnbp = $datas->whereIn('dok_pelepasan', $this->dokumenKh)
                             ->where('total_pnbp', 0.0)
                             ->first();

        }
        
        // Jika Pada Pengecekan ditemukan data PNBP 0 Pada Dokumen pelepasan yang seharusnya 
        // dikenakan tarif PNBP -> maka kirim pesan error
        return collect($cekPnbp)->when(! is_null($cekPnbp) || $cekPnbp !== null, function($i){

            $this->success = -1;

            return false;

        }, function($i){

            return true;

        });
    }

    /**
     * Menubah nomor sertifikat menjadi nomor kwitansi
     *
     * @param array $datas
     * @return string|null
     */
    private function buildNoKwitansi($datas)
    {
        // Jika terdapat pnbp maka rangkai nomor kwitansi
        if (! is_null($datas['no_seri']) && (int) $datas['total_pnbp'] !== 0) {

            $ex = explode('.', $datas['nomor_dok_pelepasan']);

            return "$ex[0].$ex[1].$ex[2].$ex[3].KWI.$ex[5].$ex[6]/1";
        }
    }

    /**
     * Digunakan untuk pengecekan apakah laporan sudah pernah diupload
     * atau belum, jika laporan sudah pernah diupload, maka update
     * sebaliknya, insert data baru ke database
     *
     * @param array $datas
     * @return int
     */
    private function forInsertOrUpdate($datas)
    {
        // Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum, 
        // jika sudah lakukan update, jika belum insert baru
        $no_permohonan  = $datas->whereNotIn('no_permohonan', ['IDEM'])
                                ->pluck('no_permohonan')
                                ->all();

        $result         = $this->model::whereNotIn('no_permohonan', ['IDEM'])
                               ->whereIn('no_permohonan', $no_permohonan)
                               ->first();

        return $result === null ? 0 : $result->count();
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

        $this->linkNotify       =   route($this->type_karantina .
                                          '.view.page.detail.bigtable.'. 
                                           $this->model->alias,
                                           [
                                            \Carbon::parse($this->tanggal)->format('Y'),
                                            \Carbon::parse($this->tanggal)->format('m'),
                                            $wilker_id
                                           ]
                                        );

        $this->notifyMessage    =   "Laporan 
                                    {$this->request->jenis_permohonan} 
                                    {$this->model->karantina} 
                                    {$this->wilker->nama_wilker} Bulan 
                                    " .bulan( \Carbon::parse($this->tanggal)->format('m') ). " 
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
