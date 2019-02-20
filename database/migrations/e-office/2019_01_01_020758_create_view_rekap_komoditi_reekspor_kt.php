<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRekapKomoditiReeksporKt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_rekap_komoditi_reekspor_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM reekspor_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_rekap_komoditi_reekspor_kt");
    }
}
