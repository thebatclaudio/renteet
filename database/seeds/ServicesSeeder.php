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
        Service::create(['name' => 'TV', 'icon_class' => 'fa-tv', 'quantity_needed' => true]);
        Service::create(['name' => 'Termosifone', 'icon_class' => 'fa-th', 'quantity_needed' => true]);
        Service::create(['name' => 'Camino', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Aria condizionata', 'icon_class' => 'fa-thermometer-half', 'quantity_needed' => true]);
        Service::create(['name' => 'Scrivania', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Doccia', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Vasca da bagno', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Internet', 'icon_class' => 'fa-fire', 'quantity_needed' => false]);
        Service::create(['name' => 'Forno', 'icon_class' => 'fa-fire', 'quantity_needed' => false]);
        Service::create(['name' => 'Posti auto privati', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Phon', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Ferro da stiro', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Accessibilità per disabili', 'icon_class' => 'fa-fire', 'quantity_needed' => false]);
        Service::create(['name' => 'Animali domestici', 'icon_class' => 'fa-fire', 'quantity_needed' => false]);
        Service::create(['name' => 'Lavatrice', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Lavastoviglie', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Terrazzo', 'icon_class' => 'fa-fire', 'quantity_needed' => true]);
        Service::create(['name' => 'Ascensore', 'icon_class' => 'fa-fire', 'quantity_needed' => false]);
    }
}
