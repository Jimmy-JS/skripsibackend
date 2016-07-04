<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('questionnaire_scores', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('questionnaire_group_id');
        //     $table->integer('user_id');
        //     $table->float('final_score');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop('questionnaire_scores');
    }
}
