<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManifoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifolds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id')->unsigned();
            $table->string('codigo', 190);
            $table->string('nombre', 1000);
            $table->string('dependencia', 190);
            $table->boolean('estado')->default(1);
            $table->foreignId("entity_id")->constrained("entities");
            $table->foreignId("region_id")->nullable()->constrained("regions");
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
        Schema::dropIfExists('manifolds');
    }
}
