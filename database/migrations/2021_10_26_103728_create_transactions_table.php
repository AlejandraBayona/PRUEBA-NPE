<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->string('npe',34)->nullable(false);
            $table->string('number_cod_bar',54)->nullable(false);
            $table->string('correlativo',7)->nullable(false);
            $table->integer('origen_pago')->nullable(false);
            $table->string('referencia', 10)->nullable(false);
            $table->boolean('estado_pago')->default(0)->change();
            $table->float('total_pagar', 8, 2)->nullable(false);
            $table->float('retencion', 8, 2);
            $table->float('total_con_retencion', 8, 2);
            $table->dateTime('fecha_emision')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('fecha_vencimiento')->nullable();
            $table->foreignId("entity_id")->constrained("entities");
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
        Schema::dropIfExists('transactions');
    }
}
