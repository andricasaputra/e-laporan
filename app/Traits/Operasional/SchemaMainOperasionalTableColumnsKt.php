<?php

namespace App\Traits\Operasional;

use Illuminate\Database\Schema\Blueprint;

trait SchemaMainOperasionalTableColumnsKt
{   
  public function setColumns(Blueprint $table)
  {
      $table->increments('id');
      $table->integer('wilker_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->date('bulan')->index()->nullable();
      $table->integer('no')->default(0)->nullable();            
      $table->string('no_permohonan', 50)->nullable();
      $table->string('no_aju', 50)->index()->nullable();
      $table->date('tanggal_permohonan')->index()->nullable();
      $table->string('jenis_permohonan', 10)->index()->nullable();
      $table->string('nama_pemohon')->index()->nullable();
      $table->text('nama_pengirim')->nullable();
      $table->text('alamat_pengirim')->nullable();
      $table->text('nama_penerima')->nullable();
      $table->text('alamat_penerima')->nullable();
      $table->string('jumlah_kemasan', 50)->default('-')->nullable();
      $table->string('kota_asal')->nullable();
      $table->string('asal')->nullable();
      $table->string('kota_tuju')->index()->nullable();
      $table->string('tujuan')->index()->nullable();
      $table->string('port_asal')->nullable();
      $table->string('port_tuju')->index()->nullable();
      $table->string('moda_alat_angkut_terakhir', 50)->nullable();
      $table->string('tipe_alat_angkut_terakhir', 50)->nullable();
      $table->string('nama_alat_angkut_terakhir')->nullable();
      $table->string('status_internal', 50)->nullable();
      $table->string('lokasi_mp')->nullable();
      $table->string('tempat_produksi')->nullable();
      $table->string('nama_tempat_pelaksanaan')->nullable();
      $table->double('nilai_barang_total')->nullable();
      $table->string('peruntukan', 70)->nullable();
      $table->string('golongan', 70)->nullable();
      $table->integer('kode_hs')->nullable();
      $table->string('nama_komoditas')->index()->nullable();
      $table->string('nama_komoditas_en')->nullable();
      $table->float('volume_netto', 11, 2)->default(0)->index()->nullable();
      $table->string('sat_netto', 50)->index()->nullable();
      $table->float('volume_bruto', 11, 2)->default(0)->nullable();
      $table->string('sat_bruto', 50)->nullable();
      $table->float('volume_lain', 11, 2)->default(0)->nullable();
      $table->string('sat_lain', 50)->nullable();
      $table->double('harga')->nullable();
      $table->float('volumeP1', 11, 2)->default(0)->nullable();
      $table->float('nettoP1', 11, 2)->default(0)->nullable();
      $table->float('volumeP8', 11, 2)->default(0)->nullable();
      $table->float('nettoP8', 11, 2)->default(0)->nullable();
      $table->string('dok_pelepasan', 50)->index()->nullable();
      $table->string('nomor_dok_pelepasan', 50)->index()->nullable();
      $table->date('tanggal_pelepasan')->index()->nullable();
      $table->string('no_seri', 30)->index()->nullable();
      $table->string('no_kwitansi', 100)->nullable();
      $table->text('dokumen_pendukung')->nullable();
      $table->text('kontainer')->nullable();
      $table->float('biaya_perjadin', 11, 2)->default(0)->nullable();
      $table->float('total_pnbp', 11, 2)->default(0)->index()->nullable();
      $table->timestamps();

      return $table;
  }
}

