<?php

use Illuminate\Database\Seeder;
use App\HouseType;

class HouseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HouseType::create(['name' => 'Casa singola']);
        HouseType::create(['name' => 'Appartamento']);
        HouseType::create(['name' => 'Villa']);
    }
}
