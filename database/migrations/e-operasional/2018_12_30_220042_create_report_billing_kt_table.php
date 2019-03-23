<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportBillingKtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_billing_kt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wilker_id')->unsigned();
            $table->foreign('wilker_id')->references('id')->on('wilker');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('bulan')->index()->nullable();
            $table->integer('no')->default(0)->nullable(); 
            $table->string('kode_transaksi')->nullable();
            $table->string('no_kwitansi')->index()->nullable();
            $table->timestamp('tgl_kwitansi')->nullable();
            $table->string('upt')->nullable();
            $table->string('wilker')->index()->nullable();
            $table->integer('jumlah')->default(0)->nullable();
            $table->string('kode_billing')->index()->nullable();
            $table->string('tgl_billing')->nullable();
            $table->string('kode_transaksi_simponi')->nullable();
            $table->string('ntpn')->nullable();
            $table->timestamp('tgl_bayar')->nullable();
            $table->string('bank_persepsi')->nullable();
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
        Schema::dropIfExists('report_billing_kt');
    }
}
