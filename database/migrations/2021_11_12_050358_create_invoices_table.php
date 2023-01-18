<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nrc',100);
            $table->string('codigo_solicitud',15);
            $table->string('tipo_factura',200)->nullable(false);
            $table->string('giro_contribuyente',500);
            $table->string('num_serie_retencion',100);
            $table->string('num_cor_retencion',100);
            $table->string('region_servicio',500)->nullable(false);
            $table->string('direccion',1000)->nullable(false);
            $table->string('departamento',500)->nullable(false);
            $table->string('municipio',500)->nullable(false);
            $table->string('destino_factura',500)->nullable(false);
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
        Schema::dropIfExists('invoices');
    }
}
