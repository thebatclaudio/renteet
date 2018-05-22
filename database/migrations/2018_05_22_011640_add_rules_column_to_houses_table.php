<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRulesColumnToHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->boolean('auto_accept')->default(false);
            $table->enum("gender", ['mixed', 'male', 'female'])->default('mixed');
            $table->integer('notice_months')->default(3);
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
            $table->dropColumn('auto_accept');
            $table->dropColumn("gender");
            $table->dropColumn("notice_months");
        });
    }
}
