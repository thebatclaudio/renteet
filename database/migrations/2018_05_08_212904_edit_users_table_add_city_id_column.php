<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTableAddCityIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('living_city');
            $table->dropColumn('born_city');
            $table->integer('living_city_id')->unsigned()->nullable();
            $table->foreign('living_city_id')->references('id')->on('cities');
            $table->integer('born_city_id')->unsigned()->nullable();
            $table->foreign('born_city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('living_city');
            $table->dropColumn('born_city');
        });
    }
}
