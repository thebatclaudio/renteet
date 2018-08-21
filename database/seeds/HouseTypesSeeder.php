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
        HouseType::create(['name' => 'Casa indipendente']);
        HouseType::create(['name' => 'Appartamento']);
        HouseType::create(['name' => 'Villa']);
    }
}
