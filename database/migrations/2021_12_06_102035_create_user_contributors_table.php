<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contributors', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->string('firstname', 500);
            $table->string('lastname', 500);
            $table->string('username', 500);
            $table->string('email', 500)->unique();
            $table->string('nit', 14)->unique();
            $table->string('password', 190);
            $table->boolean('estado')->default(1);
            $table->string('token_reset',500)->nullable();
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
        Schema::dropIfExists('user_contributors');
    }
}
