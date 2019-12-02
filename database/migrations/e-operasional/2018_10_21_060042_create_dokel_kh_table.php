<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Operasional\SchemaMainOperasionalTableColumnsKh;

class CreateDokelKhTable extends Migration
{
    use SchemaMainOperasionalTableColumnsKh;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokel_kh', function (Blueprint $table) {
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
        Schema::dropIfExists('dokel_kh');
    }
}
