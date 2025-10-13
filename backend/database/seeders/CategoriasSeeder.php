<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['categoria_id' => 1, 'nombre' => 'fotografia'],
            ['categoria_id' => 2, 'nombre' => 'video'],
            ['categoria_id' => 3, 'nombre' => 'objetivos'],
            ['categoria_id' => 4, 'nombre' => 'accesorios'],
        ]);
    }
}
