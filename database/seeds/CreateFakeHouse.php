<?php

use Illuminate\Database\Seeder;
use App\House;
use App\User;
use App\Photo;

class CreateFakeHouse extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $house = new House;
        $house->name = "Casa dolce casa";
        $house->street_name = "Via del Cacio Cavallo";
        $house->number = 69;
        $house->city = "Palermo";
        $house->latitude = "38.105106";
        $house->longitude = "13.351390";
        $house->owner_id = User::first()->id;
        $house->save();

        $house->photos()->saveMany([
            new Photo(['filename' => '1.jpg']),
            new Photo(['filename' => '2.jpg']),
            new Photo(['filename' => '3.jpg']),
            new Photo(['filename' => '4.jpg']),
            new Photo(['filename' => '5.jpg']),
        ]);
    }
}
