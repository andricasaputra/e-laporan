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

class OldUpload extends BaseOperasional
{
	public $message, $message_type;
	private $model, $request, $path, $type_karantina, $datas = [], $headings = [], $credentials, $tanggal, 
            $success = 0, $wilker, $users_to_notify, $notify_message, $link_notify;
	
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

                                return   $reader->ignoreEmpty(false);

					        })->get();

    	$user_id        = 	$this->checkActiveUserIdAndRequestUserId((int) $this->request->user_id);

        $wilker_id      = 	$this->setUserWilkerId((int) $this->request->wilker_id);

        /*set tanggal format Y-m-d*/

        foreach ($this->headings as $heading) :

            $lowereing  	= strtolower($heading);
            $getContent 	= explode(' ', $lowereing);
            $bulan      	= $getContent[2];
            $tahun      	= $getContent[6];
            $this->tanggal 	= $tahun.'-'.$bulan.'-01';

        endforeach;

        $this->credentials = [
            "id" => '',
            "wilker_id" => $wilker_id,
            "user_id" => $user_id,
            "bulan" => $this->tanggal
        ];

    	/*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
        if (!empty($this->datas) && $this->datas->count() > 0) :

        		/*Upload proccess start berdasarkan type karantina & model*/
                $this->type_karantina === 'kt'
            		? $this->uploadKt()
            		: $this->uploadKh($this->datas);

                /*Jika data berhasil di insert ke database*/ 
                if ($this->success > 0) {

                    /*Jika data berhasil di insert ke database tetapi file sudah pernah diupload tampilkan pesan*/ 
                    if ($this->success == 1) {
                    
                    	$this->message_type = 'success';
                        $this->message = 'File Sudah Pernah Diunggah, Tidak Ada Data Untuk Diperbarui!';

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

        else:

            $model = new $this->model;

            $model->wilker_id = $wilker_id;
            $model->user_id = $user_id;
            $model->bulan = $this->tanggal;

            $model->save();

            $this->message_type = 'success';
            $this->message = 'Data Berhasil Diimport!';

        endif;

        return $this->message($this->message_type, $this->message);
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
    private function uploadKh(RowCollection $datas)
    {
    	foreach ($datas as $key => $value) :

            if ($this->cekTotalPnbp('kh', $value->dok_pelepasan, $value->total_pnbp) === false) {

                $this->success = -1;

                return false;
            }

	        $model = new $this->model;

	        $model->wilker_id = $wilker_id;
            $model->user_id = $user_id;
            $model->no = $value->no;
            $model->bulan = $this->tanggal;
            $model->no_permohonan = $value->no_permohonan; 
            $model->no_aju = $value->no_aju; 
            $model->tanggal_permohonan = $value->tanggal_permohonan; 
            $model->jenis_permohonan = $value->jenis_permohonan; 
            $model->nama_pemohon = $value->nama_pemohon; 
            $model->nama_pengirim = $value->nama_pengirim; 
            $model->alamat_pengirim = $value->alamat_pengirim; 
            $model->nama_penerima = $value->nama_penerima; 
            $model->alamat_penerima = $value->alamat_penerima; 
            $model->jumlah_kemasan = $value->jumlah_kemasan; 
            $model->kota_asal = $value->kota_asal; 
            $model->asal = $value->asal; 
            $model->kota_tuju = $value->kota_tuju; 
            $model->tujuan = $value->tujuan; 
            $model->port_asal = $value->port_asal; 
            $model->port_tuju = $value->port_tuju; 
            $model->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir; 
            $model->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir; 
            $model->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir; 
            $model->status_internal = $value->status_internal; 
            $model->peruntukan = $value->peruntukan; 
            $model->jenis_mp = $value->jenis_mp; 
            $model->kelas_mp = $value->kelas_mp; 
            $model->kode_hs = $value->kode_hs; 
            $model->nama_mp = $value->nama_mp; 
            $model->nama_latin = $value->nama_latin; 
            $model->jumlah = $value->jumlah; 
            $model->satuan = $value->satuan; 
            $model->jantan = $value->jantan; 
            $model->betina = $value->betina; 
            $model->netto = $value->netto; 
            $model->sat_netto = $value->sat_netto; 
            $model->bruto = $value->bruto; 
            $model->sat_bruto = $value->sat_bruto; 
            $model->keterangan = $value->keterangan; 
            $model->breed = $value->breed; 
            $model->volumeP1 = $value->volumeP1; 
            $model->nettoP1 = $value->nettoP1; 
            $model->volumeP8 = $value->volumeP8; 
            $model->nettoP8 = $value->nettoP8; 
            $model->dok_pelepasan = $value->dok_pelepasan; 
            $model->nomor_dok_pelepasan = $value->nomor_dok_pelepasan; 
            $model->tanggal_pelepasan = $value->tanggal_pelepasan; 
            $model->no_seri = $value->no_seri; 
            $model->dokumen_pendukung = $value->dokumen_pendukung; 
            $model->kontainer = $value->kontainer; 
            $model->biaya_perjalanan_dinas = $value->biaya_perjalanan_dinas; 
            $model->total_pnbp = $value->total_pnbp; 

	        $cek = $this->model::where('nomor_dok_pelepasan', $value->nomor_dok_pelepasan)
	        ->where('no_seri', $value->no_seri)
	        ->where('tanggal_pelepasan', $value->tanggal_pelepasan)
	        ->where('no_permohonan', $value->no_permohonan)->first();

	        /*Jika data yang sama atau file yang sama sudah pernah diupload maka data jangan dimasukkan ke dalam database*/ 

	        if ($cek !== null) {

	            $this->success = 1;

	            continue;

	        }else{

	            $model->save();

	            $this->success = 2;
	        }

	    endforeach;

        /*Set Notifications Properties*/
        $this->setNotificationsProperties($wilker_id);
        
        /*Call Event to Notify*/
        $this->eventNotifyHandler();

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

                if ($total_pnbp == 0.0) {

                    return false;
                }

            }

            return true;

        }else{

            if ($dokumen_pelepasan == 'KH11' || 
                $dokumen_pelepasan == 'KH12' || 
                $dokumen_pelepasan == 'KH13' || 
                $dokumen_pelepasan == 'KH14') {

                if ($total_pnbp == 0.0) {

                    return false;

                }

            }

            return true;

        }
    }

    /*set flash message to given to users*/
    private function message(string $message_type, string $message) : ?Session
    {
    	return Session::flash("$message_type", "$message");
    }

    /*Set needed properties for notifications*/
    private function setNotificationsProperties(int $wilker_id)
    {
        $this->wilker           =   Wilker::find($wilker_id);

        $wilker                 =   $this->wilker;

        $this->users_to_notify  =   User::with(['wilker' => function($query) use ($wilker){

                                        $query->where('wilker.id', '!=', $wilker->id);

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

         $this->notify_message   =   "Laporan Operasional {$this->request->jenis_permohonan} Karantina Tumbuhan  Bulan " .Tanggal::bulan( (int) date('m', strtotime($this->tanggal)) ). " Sudah Terikirim";

        if ($this->type_karantina === 'kt' ) {

            $this->link_notify  =  route('kt.view.page.'. $jenis_permohonan);

        }else{

            $this->link_notify  =  route('kh.view.page.'. $jenis_permohonan);

        }

    }

    /*Fire the event notifications*/
    private function eventNotifyHandler()
    {
       new DataOperasionalUploadedEvent( $this->users_to_notify, $this->wilker->nama_wilker, 
                                                $this->tanggal, $this->notify_message, $this->link_notify );
    }
}
