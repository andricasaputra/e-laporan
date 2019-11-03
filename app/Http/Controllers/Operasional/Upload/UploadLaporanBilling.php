<?php

namespace App\Http\Controllers\Operasional\Upload;

use App\Models\User;
use App\Models\Wilker;
use Mavinoo\LaravelBatch\Batch;
use App\Events\DataOperasionalUploadedEvent;
use App\Contracts\ModelReportBillingInterface as Model;
use App\Http\Requests\UploadOperasionalRequest as Request;
use App\Http\Controllers\Operasional\Upload\UploaderInterface;
use App\Http\Controllers\Operasional\BaseOperasionalController;

class UploadLaporanBilling extends BaseOperasionalController implements UploaderInterface
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
    public  $index = 'no_kwitansi';

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
    	if (! $this->checkDataDate() ) {

    		$this->setMessageType()->flashMessage();

    		return false;	
    	} 

        // Run process upload
		$this->setData()->uploadProccess(); 

        // berikan feedback pesan kepada user setelah upload laporan
        return $this->setMessageType()->flashMessage();
    }

    /**
     * Menyiapkan data laporan
     *
     * @return void
     */
    private function setData()
    {
        // Data Asli Dimulai Dari Row Ke 7
        $datas = $this->excelData(6, false)->get();

        $this->datas = $datas->map(function($singledata, $index) {

            // transform nonwell number format pada kode transaksi simponi
            $singledata['kode_transaksi_simponi'] = str_replace(',', '', number_format($singledata['kode_transaksi_simponi']));

            return $singledata->prepend($this->request->wilker_id, 'wilker_id')
                                  ->prepend($this->request->user_id, 'user_id')
                                  ->prepend($this->tanggal, 'bulan')
                                  ->put('created_at', now())
                                  ->all();

            });

        return $this;
    }

    /**
     * Pengecekan tanggal laporan
     *
     * @return bool
     */
    private function checkDataDate() : bool
    {
        // Ambil Bulan Dan Tahun Pada Laporan Di Row 3
        $headings       = $this->excelData(2)->first();

        $tanggal        = explode('s/d', strtolower($headings->first()));

        $dari           = \Carbon::parse(trim(str_ireplace('periode :', '', $tanggal[0])));

        $sampai         = \Carbon::parse(trim($tanggal[1]));

        $this->tanggal  = $dari->startOfMonth();

        // Laporan harus dalam bulan yang sama
        if (! $dari->isSameMonth($sampai)) {

            $this->success = 3;

            return false;
        } 

        // Laporan harus dimulai dari awal bulan
        if ($dari->startOfMonth() !== $dari) {

            $this->success = 4;

            return false;
        }

        // Laporan harus sampai akhir bulan
        if (! $sampai->isLastOfMonth()) {

            $this->success = 5;

            return false;
        }

        return true;
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
        return  excel()->load($this->path, function($reader) use ($startRow, $ignoreEmpty) {

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
        $datas = $this->datas;

        // Jika Laporan belum pernah diupload, maka insert  
        $datas->when((int) $this->forInsertOrUpdate($datas) === 0, function ($datas) {

            $this->model->insert( $datas->all() ); 

            $this->success = 1;

            // Kirim notifikasi kepada user setelah upload
            $this->setNotificationsProperties((int) $this->request->wilker_id);

            // Call Event to Notify
            $this->eventNotifyHandler();

        // Jika sudah pernah upload maka update
        }, function($datas){

            (new Batch)->update($this->table, $datas, $this->index);

            $this->success = 2;

        });                         

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
        // Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum
        $no_kwitansi   = $datas->pluck('no_kwitansi')->all();

        $result 	   = $this->model::whereIn('no_kwitansi', $no_kwitansi)->first();

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

            case 3:

                $this->messageType = 'warning';
                $this->message = 'Laporan Harus Dalam Bulan Yang Sama!'; 
                break;

            case 4:

                $this->messageType = 'warning';
                $this->message = 'Laporan Harus Dimulai Dari Awal Bulan!'; 
                break;

            case 5:

                $this->messageType = 'warning';
                $this->message = 'Laporan Harus Hingga Akhir Bulan!'; 
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
                                          '.view.page.detail.pnbp.'. 
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
