<?php

use Illuminate\Database\Seeder;

class CreateHouseConversations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create house conversation
        foreach(\App\House::all() as $house){
            $conversation = new \App\Conversation;
            $conversation->house_id = $house->id;
            $conversation->save();
            $conversation->users()->attach($house->relatedUsers());
        }
    }
}
