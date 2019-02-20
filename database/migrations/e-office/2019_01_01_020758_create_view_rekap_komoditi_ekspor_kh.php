<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRekapKomoditiEksporKh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_rekap_komoditi_ekspor_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM ekspor_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_rekap_komoditi_ekspor_kh");
    }
}
