<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIkmResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('ikm_result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ikm_id')->unsigned();
            $table->integer('responden_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->foreign('ikm_id')->references('id')->on('ikm')->onDelete('cascade');
            $table->foreign('responden_id')->references('id')->on('ikm_responden')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('ikm_question')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('ikm_answer')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('ikm_result');
    }
}
