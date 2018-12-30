<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerahTerimaKtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serah_terima_kt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wilker_id')->unsigned();
            $table->foreign('wilker_id')->references('id')->on('wilker');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->string('peruntukan', 70)->nullable();
            $table->string('golongan', 70)->nullable();
            $table->integer('kode_hs')->nullable();
            $table->string('nama_komoditas')->index()->nullable();
            $table->string('nama_komoditas_en')->nullable();
            $table->integer('volume_netto')->default(0)->index()->nullable();
            $table->string('sat_netto', 50)->index()->nullable();
            $table->integer('volume_bruto')->default(0)->nullable();
            $table->string('sat_bruto', 50)->nullable();
            $table->integer('volume_lain')->default(0)->nullable();
            $table->string('sat_lain', 50)->nullable();
            $table->integer('volumeP1')->default(0)->nullable();
            $table->integer('nettoP1')->default(0)->nullable();
            $table->integer('volumeP8')->default(0)->nullable();
            $table->integer('nettoP8')->default(0)->nullable();
            $table->string('dok_pelepasan', 50)->index()->nullable();
            $table->string('nomor_dok_pelepasan', 50)->index()->nullable();
            $table->date('tanggal_pelepasan')->index()->nullable();
            $table->integer('no_seri')->index()->nullable();
            $table->text('dokumen_pendukung')->nullable();
            $table->text('kontainer')->nullable();
            $table->integer('biaya_perjadin')->default(0)->nullable();
            $table->integer('total_pnbp')->default(0)->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serah_terima_kt');
    }
}
