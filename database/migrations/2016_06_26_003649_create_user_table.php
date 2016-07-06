<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_seq');
            $table->string('name');
            $table->string('email');
            $table->string('auth_key');
            $table->string('password');
            $table->dateTime('dt_update');
            $table->dateTime('dt_create');
            $table->rememberToken();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
