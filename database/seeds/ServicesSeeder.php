<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: trovare le icone giuste
        Service::create(['name' => 'TV', 'icon_class' => 'fa-tv']);
        Service::create(['name' => 'Termosifone', 'icon_class' => 'fa-th']);
        Service::create(['name' => 'Camino', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Aria condizionata', 'icon_class' => 'fa-thermometer-half']);
        Service::create(['name' => 'Scrivania', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Doccia', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Vasca da bagno', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Internet', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Forno', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Garage', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Phon', 'icon_class' => 'fa-fire']);
        Service::create(['name' => 'Ferro da stiro', 'icon_class' => 'fa-fire']);
    }
}
