<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Operasional\SchemaMainOperasionalTableColumnsKh;

class CreateEksporKhTable extends Migration
{
    use SchemaMainOperasionalTableColumnsKh;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekspor_kh', function (Blueprint $table) {
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
        Schema::dropIfExists('ekspor_kh');
    }
}
