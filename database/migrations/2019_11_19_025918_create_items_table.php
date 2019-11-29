<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_item');
            $table->integer('item_code')->unique();
            $table->text('image');            
            $table->integer('stock');
            $table->bigInteger('id_store')->unsigned();            
            $table->bigInteger('buy_cost')->unsigned();            
            $table->bigInteger('sell_cost')->unsigned();            
            $table->bigInteger('id_kategory')->unsigned();            
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
        Schema::dropIfExists('items');
    }
}
