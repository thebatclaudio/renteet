<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMessagesTableRemoveToHouseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_to_house_id_foreign');
            $table->dropColumn('to_house_id');
            $table->integer('conversation_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('to_house_id')->unsigned()->nullable();
            $table->foreign('to_house_id')->references('id')->on('houses');
            $table->dropForeign('messages_conversation_id_foreign');
            $table->dropColumn('conversation_id');
        });
    }
}
