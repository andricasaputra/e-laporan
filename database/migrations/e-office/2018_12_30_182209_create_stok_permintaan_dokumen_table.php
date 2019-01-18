<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokPermintaanDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_permintaan_dokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stok_id')->index();
            $table->unsignedInteger('permintaan_dokumen_id')->index();
            $table->timestamps();

            $table->foreign('stok_id')->references('id')->on('stok_dokumen');
            $table->foreign('permintaan_dokumen_id')->references('id')->on('permintaan_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_permintaan_dokumen');
    }
}
