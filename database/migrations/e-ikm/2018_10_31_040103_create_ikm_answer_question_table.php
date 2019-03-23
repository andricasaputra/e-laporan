<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIkmAnswerQuestionTable extends Migration
{
    /**
     * Run the migrations pivot tables.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('ikm_answer_question', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('answer_id')->unsigned();
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
        Schema::connection('mysql2')->dropIfExists('ikm_answer_question');
    }
}
