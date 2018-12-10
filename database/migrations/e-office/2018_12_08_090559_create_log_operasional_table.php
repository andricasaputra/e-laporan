<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogOperasionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_operasional', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->date('bulan');
            $table->unsignedInteger('wilker_id');
            $table->string('status')->nullable();
            $table->dateTime('rolledback_at')->nullable();
            $table->foreign('wilker_id')->references('id')->on('wilker');
            $table->timestamps();
            $table->index(['type', 'bulan', 'wilker_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_operasional');
    }
}
