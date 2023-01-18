<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nombre',500)->nullable(false);
            $table->string('apellido',500);
            $table->string('nit',100)->nullable(false);
            $table->string('tipo_contribuyente',500)->nullable(false);
            $table->string('email',500)->nullable(false);
            $table->foreignId("transaction_id")->constrained("transactions");
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
        Schema::dropIfExists('contributors');
    }
}
