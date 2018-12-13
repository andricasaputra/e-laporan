<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use App\Models\User;
use App\Models\Wilker;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Events\DataOperasionalUploadedEvent;
use Maatwebsite\Excel\Collections\RowCollection;
use App\Contracts\ModelOperasionalInterface as Model;
use App\Http\Controllers\TanggalController as Tanggal;

class UploadController extends BaseOperasionalController
{
	private $model;
    private $request;
    private $path;
    private $type_karantina;
    private $datas = [];
    private $headings = [];
    private $success = 0;
    public  $tanggal;
    public  $table;
    public  $wilker;
    public  $usersToNotify;
    public  $notifyMessage;
    public  $linkNotify;
	
    public function __construct(Model $model, Request $request, 
                                string $path, string $type_karantina)
    {
    	$this->model 			= $model;

        $this->table            = $model->getTable();

    	$this->request 			= $request;

    	$this->path 			= $path;

    	$this->type_karantina 	= strtolower($type_karantina);
    }

    /**
     *Method utama untuk upload file 
     *
     * @return string || flash message
     */
    public function uploadData()
    {
    	/*Ambil Bulan Dan Tahun Pada Laporan Di Row 3*/
        $this->headings	= 	Excel::selectSheetsByIndex(0)->load($this->path, function($reader) {

					            config(['excel.import.startRow' => 3]);

					        })->first()->toArray();

        /*Data Asli Dimulai Dari Row Ke 7*/
        $this->datas 	= 	Excel::selectSheetsByIndex(0)->load($this->path, function($reader) {
            
					            config(['excel.import.startRow' => 7]);

                                return $reader->ignoreEmpty(false);

					        })->get();

        /*Set User ID Berdasarkan User yang mengupload laporan*/
    	$user_id        = 	$this->checkActiveUserIdAndRequestUserId((int) $this->request->user_id);

        /*Set Wilker ID Berdasarkan User yang mengupload laporan*/
        $wilker_id      = 	$this->setUserWilkerId((int) $this->request->wilker_id);

        /*set tanggal format Y-m-d*/
        foreach ($this->headings as $heading) :

            $lowereing  	= strtolower($heading);
            $getContent 	= explode(' ', $lowereing);
            $bulan      	= $getContent[2];
            $tahun      	= $getContent[6];
            $this->tanggal 	= "{$tahun}-{$bulan}-01";

        endforeach;

    	/*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
        if (! empty($this->datas) && $this->datas->count() > 0) :

    		/*Run Upload Proccess*/
            $this->uploadProccess(); 

        /*File laporan yang diupload benar tetapi data nihil*/
        else:

            $model = new $this->model;

            $model->wilker_id = $wilker_id;
            $model->user_id = $user_id;
            $model->bulan = $this->tanggal;

            $model->save();

            $this->success = 1;

        endif;

        /*berikan feedback pesan kepada user setelah upload laporan*/
        return $this->setMessageType()->flashMessage();
    }

    /**
     *Method delegasi dari uploadData(), proses upload dilakukan di method ini 
     *Juga berfungsi sebagai notifikasi setter
     *
     * @return bool
     */
    private function uploadProccess()
    {
    	$datas = $this->datas->map(function($singledata){

           return $singledata->prepend($this->request->wilker_id, 'wilker_id')
                    ->prepend($this->request->user_id, 'user_id')
                    ->prepend($this->tanggal, 'bulan')
                    ->put('created_at', \Carbon::now())
                    ->all();

        });

        /*Pengecekan PNBP Berdasarkan Type Karantina & Dokumen Pelepasan*/
        if ($this->type_karantina === 'kt') {

            $cekPnbp = $datas->whereIn('dok_pelepasan', ['KT9', 'KT10', 'KT12'])
                        ->where('total_pnbp', 0.0)->first();

        }else{

            $cekPnbp = $datas->whereIn('dok_pelepasan', ['KH11', 'KH12', 'KH13', 'KH14'])
                        ->where('total_pnbp', 0.0)->first();

        }
        
        if (! is_null($cekPnbp) || $cekPnbp !== null) {
            
            $this->success = -1;

            return false;
        }

        /*Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum, jika sudah lakukan update, jika belum insert baru*/
        $no_permohonan      = $datas->whereNotIn('no_permohonan', ['IDEM'])
                                ->pluck('no_permohonan')->all();

        $forinsertOrUpdate  = $this->model::select('no_permohonan')
                                ->whereNotIn('no_permohonan', ['IDEM'])
                                ->whereIn('no_permohonan', $no_permohonan)->get();

        if ($forinsertOrUpdate === null || count($forinsertOrUpdate) === 0) {

            $insertOrUpdate = $this->model->insert($datas->all()); 

        }else{

            foreach ($datas as $key => $value) {

               $this->model->whereNotIn('no_permohonan', ['IDEM'])
               ->where('no_permohonan', $value['no_permohonan'])
               ->where('kode_hs', $value['kode_hs'])
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
     *Set tipe pesan sesuai hasil upload laporan
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
     *Jika laporan berhasil diupload, method ini bertugas untuk mengatur kebutuhan pesan
     *notifikasi
     *
     * @return void
     */
    private function setNotificationsProperties(int $wilker_id)
    {
        $this->wilker           =   Wilker::find($wilker_id);

        $this->usersToNotify    =   User::with(['wilker' => function($query){

                                        $query->where('wilker.id', '!=', $this->wilker->id);

                                    }])->get();

        switch ($this->request->jenis_permohonan) :

            case 'Domestik Keluar':

                $jenis_permohonan = 'dokel';
                break;

            case 'Domestik Masuk':

                $jenis_permohonan = 'domas';
                break;

            case 'Ekspor':

                $jenis_permohonan = 'ekspor';
                break;

            default:

                $jenis_permohonan = 'impor';
                break;

        endswitch;

        $jenis_karantina        =  $this->type_karantina === 'kt' 
                                    ? 'Karantina Tumbuhan' 
                                    : 'Karantina Hewan';

        $this->linkNotify       =   $this->type_karantina === 'kt' 
                                    ? route('kt.view.page.'. $jenis_permohonan)
                                    : route('kh.view.page.'. $jenis_permohonan);

        $this->notifyMessage    =   "Laporan {$this->request->jenis_permohonan} 
                                    {$jenis_karantina} {$this->wilker->nama_wilker} Bulan 
                                    " .Tanggal::bulan( (int) date('m', strtotime($this->tanggal)) ). " 
                                    Sudah Terikirim";

    }

    /**
     *Eksekutor notifikasi
     *
     * @return void
     */
    private function eventNotifyHandler()
    {
       new DataOperasionalUploadedEvent($this);
    }
}
