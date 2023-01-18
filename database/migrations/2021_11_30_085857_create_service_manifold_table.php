<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceManifoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_manifold', function (Blueprint $table) {
            
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('manifold_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('manifold_id')->references('id')->on('manifolds');

        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_manifold');
    }
}
