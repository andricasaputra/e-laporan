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
use App\Models\Operasional\ModelOperasionalInterface;
use App\Http\Controllers\TanggalController as Tanggal;

class Upload extends BaseOperasional
{
	private $model;
    private $request;
    private $path;
    private $type_karantina;
    private $datas = [];
    private $headings = [];
    private $tanggal;
    private $success = 0;
    private $wilker;
    private $users_to_notify;
    private $notify_message;
    private $link_notify;
    public  $message;
    public  $message_type;
	
    public function __construct(ModelOperasionalInterface $model, Request $request, 
                                string $path, string $type_karantina)
    {
    	$this->model 			= $model;

    	$this->request 			= $request;

    	$this->path 			= $path;

    	$this->type_karantina 	= strtolower($type_karantina);
    }

    /*Main upload method but the real upload going to delegate to uploadKt or uploadKh method*/
    public function uploadData() : ?Upload
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
        if (!empty($this->datas) && $this->datas->count() > 0) :

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
        return $this->setMessageType()->message($this->message_type, $this->message);
    }

    /*Upload Laporan Tipe Karantina Tumbuhan*/
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

            $cekPnbp = $datas->whereIn('dok_pelepasan', ['KT9', 'KT10', 'KT12'])->where('total_pnbp', 0.0)->first();

        }else{

            $cekPnbp = $datas->whereIn('dok_pelepasan', ['KH11', 'KH12', 'KH13', 'KH14'])->where('total_pnbp', 0.0)->first();

        }
        
        if (!is_null($cekPnbp) || $cekPnbp !== null) {
            
            $this->success = -1;

            return false;
        }

        /*Pengecekan Laporan Bulanan Sudah Pernah Diupload atau belum, jika sudah lakukan update, jika belum insert baru*/
        $no_permohonan      = $datas->whereNotIn('no_permohonan', ['IDEM'])->pluck('no_permohonan')->all();

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

    /*Set tipe-tipe pesan yang ingin ditampilkan kepada user*/
    private function setMessageType()
    {
        /*Jika data berhasil di insert ke database*/ 
        if ($this->success > 0) {

            /*Jika data berhasil di insert ke database tetapi file sudah pernah diupload tampilkan pesan*/ 
            if ($this->success == 1) {
            
                $this->message_type = 'success';
                $this->message = 'Data Berhasil Diimport!';

            }else{

                $this->message_type = 'success';
                $this->message = 'Data Berhasil Diperbarui!'; 

            }       

        /*Error PNBP Tidak Cocok dengan Data Sertifikat*/
        }elseif($this->success == -1){

            $this->message_type = 'warning';
            $this->message = 'Ketidaksesuaian data antara Dokumen Sertifikat dan Total PNBP ditemukan!, Total PNBP Tidak Boleh 0 pada Dokumen Sertifikat Yang dipakai';

        /*Error tidak terduga / bad connection??*/
        }else{

            $this->message_type = 'warning';
            $this->message = 'Gagal Import Data!';

        }

        return $this;
    }

    /*set flash message*/
    private function message(string $message_type, string $message) : ?Session
    {
    	return Session::flash("$message_type", "$message");
    }

    /*set property2 untuk kebutuhan notifikasi*/
    private function setNotificationsProperties(int $wilker_id)
    {
        $this->wilker           =   Wilker::find($wilker_id);

        $this->users_to_notify  =   User::with(['wilker' => function($query){

                                        $query->where('wilker.id', '!=', $this->wilker->id);

                                    }])->get();

        switch ($this->request->jenis_permohonan) {

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

        }

        $jenis_karantina = $this->type_karantina === 'kt' ? 'Karantina Tumbuhan' : 'Karantina Hewan';

        $this->notify_message   =   "Laporan Operasional {$this->request->jenis_permohonan} {$jenis_karantina} Bulan " .Tanggal::bulan( (int) date('m', strtotime($this->tanggal)) ). " Sudah Terikirim";

        $this->link_notify  =   $this->type_karantina === 'kt' 
                                ? route('kt.view.page.'. $jenis_permohonan)
                                : route('kh.view.page.'. $jenis_permohonan);

    }

    /*Panggil event notifikasi*/
    private function eventNotifyHandler()
    {
       new DataOperasionalUploadedEvent( $this->users_to_notify, $this->wilker->nama_wilker, 
                                         $this->tanggal, $this->notify_message, $this->link_notify );
    }
}
