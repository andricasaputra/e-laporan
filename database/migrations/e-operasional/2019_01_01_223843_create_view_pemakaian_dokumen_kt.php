<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewPemakaianDokumenKt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_pemakaian_dokumen_kt AS

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM dokel_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION 

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM domas_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM ekspor_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM impor_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
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
        DB::statement("DROP VIEW IF EXISTS v_pemakaian_dokumen_kt");
    }
}
