<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\DomasKt as Operasional;

class DomasKt extends Controller
{
    public function imports(Request $request) 
	{
		$user_id = Auth::user()->id;
        $wilker_id = Auth::user()->wilker_id;
	
	    if($request->hasFile('impor')){

            $path = $request->file('impor')->getRealPath();

            $datas = Excel::selectSheets('Sheet1')->load($path)->get();

            if (!empty($datas) && $datas->count() > 0) :

                    foreach ($datas as $key => $value) :

                        $domas = new Operasional;

                        $domas->wilker_id = $wilker_id;
                        $domas->user_id = $user_id;
                        $domas->no = $value->no;
                        $domas->no_permohonan = $value->no_permohonan;
                        $domas->no_aju = $value->no_aju;
                        $domas->tanggal_permohonan = $value->tanggal_permohonan;
                        $domas->jenis_permohonan = $value->jenis_permohonan;
                        $domas->nama_pemohon = $value->nama_pemohon;
                        $domas->nama_pengirim = $value->nama_pengirim;
                        $domas->alamat_pengirim = $value->alamat_pengirim;
                        $domas->nama_penerima = $value->nama_penerima;
                        $domas->alamat_penerima = $value->alamat_penerima;
                        $domas->jumlah_kemasan = $value->jumlah_kemasan;
                        $domas->kota_asal = $value->kota_asal;
                        $domas->asal = $value->asal;
                        $domas->kota_tujuan = $value->kota_tuju;
                        $domas->tujuan = $value->tujuan;
                        $domas->port_asal = $value->port_asal;
                        $domas->port_tujuan = $value->port_tuju;
                        $domas->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $domas->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $domas->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $domas->status_internal = $value->status_internal;
                        $domas->lokasi_mp = $value->lokasi_mp;
                        $domas->tempat_produksi = $value->tempat_produksi;
                        $domas->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $domas->peruntukan = $value->peruntukan;
                        $domas->golongan = $value->golongan;
                        $domas->kode_hs = $value->kode_hs;
                        $domas->nama_komoditas = $value->nama_komoditas;
                        $domas->nama_komoditas_en = $value->nama_komoditas_en;
                        $domas->volume_netto = $value->volume_netto;
                        $domas->sat_netto = $value->sat_netto;
                        $domas->volume_bruto = $value->volume_bruto;
                        $domas->sat_bruto = $value->sat_bruto;
                        $domas->volume_lain = $value->volume_lain;
                        $domas->sat_lain = $value->sat_lain;
                        $domas->volumeP1 = $value->volumep1;
                        $domas->nettoP1 = $value->nettop1;
                        $domas->volumeP8 = $value->volumep8;
                        $domas->nettoP8 = $value->nettop8;
                        $domas->dok_pelepasan = $value->dok_pelepasan;
                        $domas->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $domas->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $domas->no_seri = $value->no_seri;
                        $domas->dokumen_pendukung = $value->dokumen_pendukung;
                        $domas->kontainer = $value->kontainer;
                        $domas->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $domas->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::find($value->no_permohonan);

                        if ($cek !== null) {

                            $success[] = 1;

                            continue;

                        }else{

                            $success[] = $domas->save();
                        }


                    endforeach;

                    if (count($success) > 0) {

                        \Session::flash('success','Data Berhasil Diimport!');

                    }else{

                        \Session::flash('warning','Gagal Import Data!');

                    }

            else:

            	\Session::flash('warning','File Yang Anda Import Kosong/ Nihil!');

            endif;

            
        }else{

            \Session::flash('warning','Harap Pilih File Untuk Diimport Terlebih Dahulu!');

        }

        return redirect()->back();

	}

    public function exports()
    {
        
    }
}
