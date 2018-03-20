<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUsersHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("house_user");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('house_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('accepted_by_owner');
            $table->boolean('interested');
            $table->timestamps();
        });
    }
}
