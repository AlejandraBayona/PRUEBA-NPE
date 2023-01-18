<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id')->unsigned();
            $table->string('nombre', 1000)->nullable(false);
            $table->string('pre_cod_loc', 10)->nullable(false);
            $table->string('cod_loc', 20)->nullable(false);
            $table->string('pre_cant_pagar', 10)->nullable(false);
            $table->string('pre_fecha_venc', 10)->nullable(false);
            $table->string('referencia', 10)->nullable(false);
            $table->string('codigo_loc_mh', 10)->nullable(false);
            $table->string('comodin', 2)->nullable(false);
            $table->string('pre_ref_pago', 4)->nullable(false);
            $table->integer('origen_pago')->nullable();
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
        Schema::dropIfExists('entities');
    }
}
