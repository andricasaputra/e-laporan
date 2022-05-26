<?php

namespace App\Traits\Operasional;

use Illuminate\Database\Schema\Blueprint;

trait SchemaPenugasanTableColumns
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
        $table->string('nama_wilker', 250)->nullable();
        $table->text('nama_pengirim')->nullable();
        $table->text('alamat_pengirim')->nullable();
        $table->text('nama_penerima')->nullable();
        $table->text('alamat_penerima')->nullable();
        $table->string('nama_tercetak', 250)->nullable();
        $table->string('nama_latin_tercetak', 250)->nullable();
        $table->string('bentuk_tercetak', 250)->nullable();
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
        $table->string('dok_pelepasan', 50)->index()->nullable();
        $table->string('nomor_dok_pelepasan', 50)->index()->nullable();
        $table->date('tanggal_pelepasan')->index()->nullable();
        $table->string('no_surat_tugas', 60)->index()->nullable();
        $table->date('tgl_surat_tugas')->index()->nullable();
        $table->text('deskripsi')->nullable();
        $table->string('petugas', 60)->index()->nullable();
        $table->text('dokumen_pendukung')->nullable();
        $table->longText('kontainer')->nullable();
        $table->timestamps(); 

        return $table;
  }
}

