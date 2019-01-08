<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewPemakaianDokumenKh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_pemakaian_dokumen_kh AS

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as total
                        FROM dokel_kh
                        WHERE dok_pelepasan IS NOT NULL
                        GROUP BY dokumen, bulan, wilker_id

                        UNION 

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as total
                        FROM domas_kh
                        WHERE dok_pelepasan IS NOT NULL
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as total
                        FROM ekspor_kh
                        WHERE dok_pelepasan IS NOT NULL
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as total
                        FROM impor_kh
                        WHERE dok_pelepasan IS NOT NULL
                        GROUP BY dokumen, bulan, wilker_id
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_pemakaian_dokumen_kh");
    }
}
