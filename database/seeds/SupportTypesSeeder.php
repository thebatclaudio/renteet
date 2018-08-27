<?php

use Illuminate\Database\Seeder;
use App\SupportType;

class SupportTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupportType::create(['name' => 'Richiesta di aiuto']);
        SupportType::create(['name' => 'Malfunzionamento']);
        SupportType::create(['name' => 'Consiglio']);
        SupportType::create(['name' => 'Altro']);
    }
}
