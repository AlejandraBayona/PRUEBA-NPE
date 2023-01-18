<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicetransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('codigo',50)->nullable(false);
            $table->mediumText('nombre')->nullable(false);
            $table->float('valor', 8, 2);
            $table->integer('cantidad')->nullable(false);
            $table->float('total', 8, 2);
            $table->foreignId("manifold_id")->constrained("manifolds");
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
        Schema::dropIfExists('servicetransactions');
    }
}
