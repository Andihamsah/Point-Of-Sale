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
            $table->bigIncrements('id');
            $table->bigInteger('id_member')->nullable()->unsigned();
            $table->bigInteger('id_item')->unsigned();
            $table->bigInteger('id_store')->unsigned();
            $table->string('no_transaksi');
            $table->integer('total_item');
            $table->integer('sub_total');
            $table->integer('total');
            $table->integer('pay');
            $table->integer('return');
            $table->timestamps();
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
