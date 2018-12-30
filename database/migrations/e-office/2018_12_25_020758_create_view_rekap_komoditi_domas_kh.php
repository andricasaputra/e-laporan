<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRekapKomoditiDomasKh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_rekap_komoditi_domas_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                year(created_at) as year, 
                                month(bulan) as month, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi  
                        FROM domas_kh
                        GROUP BY nama_mp
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_rekap_komoditi_domas_kh");
    }
}
