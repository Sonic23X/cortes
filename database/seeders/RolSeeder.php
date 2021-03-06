<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'root']);
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'repartidor']);
        Role::create(['name' => 'lectura']);
    }
}
