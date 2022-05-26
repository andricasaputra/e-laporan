<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Operasional\SchemaPenugasanTableColumns;

class CreatePenugasanDomasKhTable extends Migration
{
    use SchemaPenugasanTableColumns;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan_domas_kh', function (Blueprint $table) {
           $this->setColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penugasan_domas_kh');
    }
}
