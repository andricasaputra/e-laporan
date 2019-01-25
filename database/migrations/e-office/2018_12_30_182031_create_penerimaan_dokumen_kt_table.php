<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenerimaanDokumenKtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_dokumen_kt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wilker_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('dokumen_id')->index();
            $table->integer('jumlah')->index();
            $table->string('no_seri')->nullable()->index();
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('wilker_id')->references('id')->on('wilker');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('penerimaan_dokumen_kt');
    }
}
