<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('house_id')->unsigned()->nullable();
            $table->foreign('house_id')->references('id')->on('houses');
            $table->integer('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('services');
            $table->integer('quantity');
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
        Schema::dropIfExists('houses_services');
    }
}
