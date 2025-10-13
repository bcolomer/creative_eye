<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['rol_id' => 1, 'nombre' => 'administrador'],
            ['rol_id' => 2, 'nombre' => 'almacen'],
            ['rol_id' => 3, 'nombre' => 'cliente'],
        ]);
    }
}
