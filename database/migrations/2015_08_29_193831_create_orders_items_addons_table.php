<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersItemsAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items_addons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('orders_item_id')->unsigned();
            $table->foreign('orders_item_id')->references('id')->on('orders_items')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('addon_id')->unsigned();
            $table->foreign('addon_id')->references('id')->on('addons')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty')->unsigned();
            $table->decimal('price_per_item',8,2);
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
        Schema::drop('orders_items_addons');
    }
}
