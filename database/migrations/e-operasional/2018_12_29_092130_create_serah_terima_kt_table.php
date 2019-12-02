<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Operasional\SchemaMainOperasionalTableColumnsKt;

class CreateSerahTerimaKtTable extends Migration
{
    use SchemaMainOperasionalTableColumnsKt;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serah_terima_kt', function (Blueprint $table) {
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
        Schema::dropIfExists('serah_terima_kt');
    }
}
