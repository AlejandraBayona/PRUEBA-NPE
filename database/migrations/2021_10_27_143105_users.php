<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table){

            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->string('firstname', 500);
            $table->string('lastname', 500);
            $table->string('email', 500)->unique();
            $table->string('password', 190);
            $table->bigInteger('collector_site');
            $table->boolean('estado')->default(1);
            $table->dateTime('created_at', 0)->nullable();
            $table->dateTime('updated_at', 0)->nullable();
        });
    }

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
