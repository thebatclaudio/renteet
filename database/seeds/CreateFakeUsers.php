<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateFakeUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creo 3 utenti 
        $faker = Faker\Factory::create();
        $user = new User;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->password = Hash::make('password');
        $user->email = $faker->email;
        $user->birthday = $faker->date("Y-m-d");
        $user->save();
        $user->assignRole('tenant');

        $faker = Faker\Factory::create();
        $user = new User;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->password = Hash::make('password');
        $user->email = $faker->email;
        $user->birthday = $faker->date("Y-m-d");
        $user->save();
        $user->assignRole('tenant');

        $faker = Faker\Factory::create();
        $user = new User;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->password = Hash::make('password');
        $user->email = $faker->email;
        $user->birthday = $faker->date("Y-m-d");
        $user->save();
        $user->assignRole('tenant');

        // e un locatore
        $faker = Faker\Factory::create();
        $user = new User;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->password = Hash::make('password');
        $user->email = $faker->email;
        $user->birthday = $faker->date("Y-m-d");
        $user->save();
        $user->assignRole('lessor');
    }
}
