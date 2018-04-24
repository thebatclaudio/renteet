<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateRoles::class);
        $this->call(CreateFakeUsers::class);
        $this->call(CreateFakeHouse::class);
        $this->call(CreateFakeRooms::class);
        $this->call(CreateFakeReview::class);
    }
}
