<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermintaanDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_dokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wilker_id')->index();
            $table->unsignedInteger('dokumen_id')->index();
            $table->integer('jumlah')->index();
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('wilker_id')->references('id')->on('wilker');
            $table->foreign('dokumen_id')->references('id')->on('master_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_dokumen');
    }
}
