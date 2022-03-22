<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembatalanDokKhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembatalan_dok_kh', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wilker_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('bulan')->index()->nullable();
            $table->integer('no')->default(0)->nullable();
            $table->string('no_permohonan', 50)->nullable();
            $table->string('no_aju', 50)->index()->nullable();
            $table->date('tanggal_permohonan')->index()->nullable();
            $table->string('jenis_permohonan', 10)->index()->nullable();
            $table->string('dokumen', 50)->index()->nullable();
            $table->integer('nomor_seri')->index()->nullable();
            $table->text('alasan')->nullable();
            $table->date('tanggal_batal')->index()->nullable();
            $table->string('mengetahui')->nullable();
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
        Schema::dropIfExists('pembatalan_dok_kh');
    }
}
