<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersStatusDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_status_descriptions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('orders_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->integer('languages_id')->unsigned();
            $table->foreign('languages_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->integer('orders_status_id')->unsigned();
            $table->foreign('orders_status_id')->references('id')->on('orders_status')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('orders_status_descriptions');
    }
}
