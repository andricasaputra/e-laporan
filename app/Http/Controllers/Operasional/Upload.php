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
    private $credentials;
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

        /*Set Credentials user untuk keperluan merge insert ke database*/
        $this->credentials = [

            "wilker_id" => $wilker_id,
            "user_id" => $user_id,
            "bulan" => $this->tanggal

        ];

    	/*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
        if (!empty($this->datas) && $this->datas->count() > 0) :

    		/*Upload proccess start berdasarkan type karantina & model*/
            $this->type_karantina === 'kt' ? $this->uploadKt() : $this->uploadKh(); 

        /*File laporan yang diupload benar tetapi data nihil*/
        else:

            $model = new $this->model;

            $model->wilker_id = $wilker_id;
            $model->user_id = $user_id;
            $model->bulan = $this->tanggal;

            $model->save();

            $this->message_type = 'success';
            $this->message = 'Data Berhasil Diimport!';

        endif;

        /*Set Notifications Properties*/
        $this->setNotificationsProperties($wilker_id);

        /*Call Event to Notify*/
        $this->eventNotifyHandler();

        /*berikan feedback pesan kepada user setelah upload laporan*/
        return $this->setMessageType()->message($this->message_type, $this->message);
    }

    /*Upload Laporan Tipe Karantina Tumbuhan*/
    private function uploadKt()
    {
    	foreach ($this->datas as $key => $value) :
            
            /*Cek Total PNBP Berdasarkan Jenis Dokumen Karantinanya*/
            if ($this->cekTotalPnbp('kt', $value->dok_pelepasan, $value->total_pnbp) === false) {

                $this->success = -1;

                return false;
            }

            /*Merge data dari laporan dengan credentials user*/
            $datas = $value->map(function($singledata){

                return $singledata;

            })->merge($this->credentials)->all();
        
            /*Cek kembali apakah data sudah pernah diupload atau belum, Jika sudah lakukan update*/
	        $cek = $this->model::where('nomor_dok_pelepasan', $value->nomor_dok_pelepasan)
	        ->where('no_seri', $value->no_seri)
	        ->where('tanggal_pelepasan', $value->tanggal_pelepasan)
	        ->where('no_permohonan', $value->no_permohonan)->first();

	        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

            /*Update data*/
	        if ($cek !== null) {

	            $this->model->whereId($cek->id)->update($datas);

                $this->success = 1;

            /*Insert data*/
	        }else{

                $this->model->create($datas);

	            $this->success = 2;
                
	        }

	    endforeach;

	    return $this->success;
    }

    /*Upload Laporan Tipe Karantina Hewan*/
    private function uploadKh()
    {
    	foreach ($this->datas as $key => $value) :
            
            /*Cek Total PNBP Berdasarkan Jenis Dokumen Karantinanya*/
            if ($this->cekTotalPnbp('kt', $value->dok_pelepasan, $value->total_pnbp) === false) {

                $this->success = -1;

                return false;
            }

            $datas = $value->map(function($singledata){

                return $singledata;

            })->merge($this->credentials)->all();
        
            $cek = $this->model::where('nomor_dok_pelepasan', $value->nomor_dok_pelepasan)
            ->where('no_seri', $value->no_seri)
            ->where('tanggal_pelepasan', $value->tanggal_pelepasan)
            ->where('no_permohonan', $value->no_permohonan)->first();

            /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

            if ($cek !== null) {

                $this->model->whereId($cek->id)->update($datas);

                $this->success = 1;

            }else{

                $this->model->create($datas);

                $this->success = 2;
                
            }

        endforeach;

        return $this->success;
    }

    /*
    |Untuk Cek Kesesuaian Total PNBP Dengan Jenis Dokumen Karantina
    |Kasus yang sering terjadi ketika export data dari IQFAST notifikasi sukses belum keluar,
    |Tetapi laporan excel sudah dibuka, ini mengakibatkan semua total pnbp pada laporan menjadi 0
    */
    private function cekTotalPnbp($type_karantina, $dokumen_pelepasan, $total_pnbp)
    {
        if($type_karantina === 'kt'){

            if ($dokumen_pelepasan == 'KT12' || 
                $dokumen_pelepasan == 'KT10' || 
                $dokumen_pelepasan == 'KT9') {

                if ($total_pnbp == 0.0 || $total_pnbp == 0) {

                    return false;
                }

            }

            return true;

        }else{

            if ($dokumen_pelepasan == 'KH11' || 
                $dokumen_pelepasan == 'KH12' || 
                $dokumen_pelepasan == 'KH13' || 
                $dokumen_pelepasan == 'KH14') {

                if ($total_pnbp == 0.0 || $total_pnbp == 0) {

                    return false;

                }

            }

            return true;

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
                $this->message = 'Data Berhasil Diperbarui!';

            }else{

                $this->message_type = 'success';
                $this->message = 'Data Berhasil Diimport!';

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
