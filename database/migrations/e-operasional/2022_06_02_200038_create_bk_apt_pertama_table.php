<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBkAptPertamaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("  CREATE TABLE `bk_apt_pertama` 
            (
                `no` varchar(20) DEFAULT NULL,
                `kode_butir` varchar(100) DEFAULT NULL,
                `nama_butir` varchar(255) DEFAULT NULL,
                `ak` varchar(50) DEFAULT NULL,
                `satuan` varchar(255) DEFAULT NULL,
                UNIQUE KEY `no` (`no`),
                KEY `id` (`no`)
            )   ENGINE=InnoDB DEFAULT CHARSET=latin1
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TABLE IF EXISTS bk_apt_pertama");
    }
}
