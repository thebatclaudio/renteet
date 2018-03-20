<?php

use Illuminate\Database\Seeder;
use App\Room;

class CreateFakeRooms extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $room = new Room;
        $room->beds = 2;
        $room->house_id = 1;
        $room->save();

        $faker = Faker\Factory::create();
        $room = new Room;
        $room->beds = 1;
        $room->house_id = 1;
        $room->save();

        $faker = Faker\Factory::create();
        $room = new Room;
        $room->beds = 1;
        $room->house_id = 1;
        $room->save();
    }
}
