<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRekapKomoditiDokelKt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_rekap_komoditi_dokel_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                year(created_at) as year, 
                                month(bulan) as month, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM dokel_kt
                        GROUP BY nama_komoditas
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_rekap_komoditi_dokel_kt");
    }
}
