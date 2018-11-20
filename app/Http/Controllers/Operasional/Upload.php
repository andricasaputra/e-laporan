<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Operasional\ModelInterface;
use Maatwebsite\Excel\Collections\RowCollection;

class Upload extends BaseOperasional
{
	public $message, $message_type;
	private $model, $request, $path, $type_karantina, $datas = [], $headings = [], $tanggal, $success = 0;
	
    public function __construct(ModelInterface $model, Request $request, string $path, string $type_karantina)
    {
    	$this->model 			= $model;

    	$this->request 			= $request;

    	$this->path 			= $path;

    	$this->type_karantina 	= strtolower($type_karantina);
    }

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

    	$user_id        = 	$this->checkActiveUserIdAndRequestUserId((int) $this->request->user_id);

        $wilker_id      = 	$this->setUserWilkerId((int) $this->request->wilker_id);

        $wilker_user    = 	$this->setUserWilker();

        /*set tanggal format Y-m-d*/
        foreach ($this->headings as $heading) :

            $lowereing  	= strtolower($heading);
            $getContent 	= explode(' ', $lowereing);
            $bulan      	= $getContent[2];
            $tahun      	= $getContent[6];
            $this->tanggal 	= $tahun.'-'.$bulan.'-01';

        endforeach;

    	/*Jika semua validasi berhasil & jika file tidak kosong maka insert ke database*/
        if (!empty($this->datas) && $this->datas->count() > 0) :

        		/*Upload proccess start berdasarkan type karantina & model*/
                $this->type_karantina === 'kt'
            		? $this->uploadKt($this->datas, $user_id, $wilker_id)
            		: $this->uploadKh($this->datas, $user_id, $wilker_id);

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

    private function uploadKt(RowCollection $datas, int $user_id, int $wilker_id) : int
    {
    	foreach ($datas as $key => $value) :

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
	        $model->kota_tujuan = $value->kota_tuju;
	        $model->tujuan = $value->tujuan;
	        $model->port_asal = $value->port_asal;
	        $model->port_tujuan = $value->port_tuju;
	        $model->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
	        $model->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
	        $model->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
	        $model->status_internal = $value->status_internal;
	        $model->lokasi_mp = $value->lokasi_mp;
	        $model->tempat_produksi = $value->tempat_produksi;
	        $model->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
	        $model->peruntukan = $value->peruntukan;
	        $model->golongan = $value->golongan;
	        $model->kode_hs = $value->kode_hs;
	        $model->nama_komoditas = $value->nama_komoditas;
	        $model->nama_komoditas_en = $value->nama_komoditas_en;
	        $model->volume_netto = $value->volume_netto;
	        $model->sat_netto = $value->sat_netto;
	        $model->volume_bruto = $value->volume_bruto;
	        $model->sat_bruto = $value->sat_bruto;
	        $model->volume_lain = $value->volume_lain;
	        $model->sat_lain = $value->sat_lain;
	        $model->volumeP1 = $value->volumep1;
	        $model->nettoP1 = $value->nettop1;
	        $model->volumeP8 = $value->volumep8;
	        $model->nettoP8 = $value->nettop8;
	        $model->dok_pelepasan = $value->dok_pelepasan;
	        $model->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
	        $model->tanggal_pelepasan = $value->tanggal_pelepasan;
	        $model->no_seri = $value->no_seri;
	        $model->dokumen_pendukung = $value->dokumen_pendukung;
	        $model->kontainer = $value->kontainer;
	        $model->biaya_perjalanan_dinas = $value->biaya_perjadin;
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

	    return $this->success;
    }

    private function uploadKh(RowCollection $datas, int $user_id, int $wilker_id) : int
    {
    	foreach ($datas as $key => $value) :

	        $model = new $this->model;

	        $model->wilker_id = $wilker_id;
            $model->user_id = $user_id;
            $model->no = $value->no;
            $model->bulan = $tanggal_laporan[0]; 
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

	    return $this->success;
    }

    private function message(string $message_type, string $message) : ?Session
    {
    	return Session::flash("$message_type", "$message");
    }
}
