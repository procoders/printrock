<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('addons_type_id')->unsigned();
            $table->foreign('addons_type_id')->references('id')->on('addons_types')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image', 255);
            $table->enum('price_type', ['price', 'percent']);
            $table->float('price')->unsigned();
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
        Schema::drop('addons');
    }
}
