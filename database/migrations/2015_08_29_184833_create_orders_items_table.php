<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('orders_id')->unsigned();
            $table->foreign('orders_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('photo_id')->unsigned();
            $table->integer('qti')->unsigned();
            $table->float('price_per_item')->unsigned();
            $table->integer('format_id')->unsigned();
            $table->integer('formats_id')->unsigned();
            $table->foreign('formats_id')->references('id')->on('formats')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('orders_items');
    }
}
