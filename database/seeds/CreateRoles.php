<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'tenant']);
        $role = Role::create(['name' => 'lessor']);
    }
}
