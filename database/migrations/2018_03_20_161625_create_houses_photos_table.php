<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses');
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
        Schema::dropIfExists('houses_photos');
    }
}
