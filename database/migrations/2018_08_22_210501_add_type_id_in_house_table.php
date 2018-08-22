<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeIdInHouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->integer('type_id')->unsigned()->nullable(false)->default(1);
            $table->foreign('type_id')->references('id')->on('house_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign('houses_type_id_foreign');
            $table->dropColumn('type_id');
        });
    }
}
