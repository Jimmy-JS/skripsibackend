<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nim')->unique();
            $table->integer('study_program_id');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->char('gender', 1);
            $table->string('id_number');
            $table->char('class', 4);
            $table->string('phone');
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('religion');
            $table->text('address');
            $table->boolean('is_admin');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
