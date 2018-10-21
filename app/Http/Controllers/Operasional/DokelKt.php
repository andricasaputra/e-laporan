<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Operasional\DokelKt as Operasional;

class DokelKt extends Controller
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

                        $dokel = new Operasional;

                        $dokel->wilker_id = $wilker_id;
                        $dokel->user_id = $user_id;
                        $dokel->no = $value->no;
                        $dokel->no_permohonan = $value->no_permohonan;
                        $dokel->no_aju = $value->no_aju;
                        $dokel->tanggal_permohonan = $value->tanggal_permohonan;
                        $dokel->jenis_permohonan = $value->jenis_permohonan;
                        $dokel->nama_pemohon = $value->nama_pemohon;
                        $dokel->nama_pengirim = $value->nama_pengirim;
                        $dokel->alamat_pengirim = $value->alamat_pengirim;
                        $dokel->nama_penerima = $value->nama_penerima;
                        $dokel->alamat_penerima = $value->alamat_penerima;
                        $dokel->jumlah_kemasan = $value->jumlah_kemasan;
                        $dokel->kota_asal = $value->kota_asal;
                        $dokel->asal = $value->asal;
                        $dokel->kota_tujuan = $value->kota_tuju;
                        $dokel->tujuan = $value->tujuan;
                        $dokel->port_asal = $value->port_asal;
                        $dokel->port_tujuan = $value->port_tuju;
                        $dokel->moda_alat_angkut_terakhir = $value->moda_alat_angkut_terakhir;
                        $dokel->tipe_alat_angkut_terakhir = $value->tipe_alat_angkut_terakhir;
                        $dokel->nama_alat_angkut_terakhir = $value->nama_alat_angkut_terakhir;
                        $dokel->status_internal = $value->status_internal;
                        $dokel->lokasi_mp = $value->lokasi_mp;
                        $dokel->tempat_produksi = $value->tempat_produksi;
                        $dokel->nama_tempat_pelaksanaan = $value->nama_tempat_pelaksanaan;
                        $dokel->peruntukan = $value->peruntukan;
                        $dokel->golongan = $value->golongan;
                        $dokel->kode_hs = $value->kode_hs;
                        $dokel->nama_komoditas = $value->nama_komoditas;
                        $dokel->nama_komoditas_en = $value->nama_komoditas_en;
                        $dokel->volume_netto = $value->volume_netto;
                        $dokel->sat_netto = $value->sat_netto;
                        $dokel->volume_bruto = $value->volume_bruto;
                        $dokel->sat_bruto = $value->sat_bruto;
                        $dokel->volume_lain = $value->volume_lain;
                        $dokel->sat_lain = $value->sat_lain;
                        $dokel->volumeP1 = $value->volumep1;
                        $dokel->nettoP1 = $value->nettop1;
                        $dokel->volumeP8 = $value->volumep8;
                        $dokel->nettoP8 = $value->nettop8;
                        $dokel->dok_pelepasan = $value->dok_pelepasan;
                        $dokel->nomor_dok_pelepasan = $value->nomor_dok_pelepasan;
                        $dokel->tanggal_pelepasan = $value->tanggal_pelepasan;
                        $dokel->no_seri = $value->no_seri;
                        $dokel->dokumen_pendukung = $value->dokumen_pendukung;
                        $dokel->kontainer = $value->kontainer;
                        $dokel->biaya_perjalanan_dinas = $value->biaya_perjadin;
                        $dokel->total_pnbp = $value->total_pnbp;

                        $cek = Operasional::find($value->no_permohonan);

                        if ($cek !== null) {

                            $success[] = 1;

                            continue;

                        }else{

                            $success[] = $dokel->save();
                        }


                    endforeach;

                    if (count($success) > 0) {

                        \Session::flash('success','Data Berhasil Diimport!');

                    }else{

                        \Session::flash('warning','Gagal Import Data!');

                    }

            endif;

            
        }else{

            \Session::flash('warning','Harap Pilih File Untuk Diimport Terlebih Dahulu!');

        }

        return redirect()->back();

	}
}

