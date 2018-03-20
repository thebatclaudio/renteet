<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTableAddMoreInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::table('users', function (Blueprint $table) {
            $table->string('living_city')->nullable();
            $table->string('born_city')->nullable();
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
