<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // updateOrCreate : idempotent (sûr pour les redémarrages)
        Role::updateOrCreate(['name' => 'Administrateur']);
        Role::updateOrCreate(['name' => 'Manager']);
        Role::updateOrCreate(['name' => 'Utilisateur']);
    }
}