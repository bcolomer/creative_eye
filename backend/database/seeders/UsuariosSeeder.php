<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('usuarios')->insert([
            [
                'usuario_id'     => 1,
                'nombre'         => 'Administrador',
                'nombre_usuario' => 'admin@creative.es',
                'foto'           => 'https://randomuser.me/api/portraits/men/45.jpg',
                'rol_id'         => 1,
                'password'       => Hash::make('12345678'),
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'usuario_id'     => 2,
                'nombre'         => 'Responsable Almacén',
                'nombre_usuario' => 'almacen@creative.es',
                'foto'           => 'https://randomuser.me/api/portraits/women/68.jpg',
                'rol_id'         => 2,
                'password'       => Hash::make('12345678'),
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'usuario_id'     => 3,
                'nombre'         => 'José Fernández',
                'nombre_usuario' => 'jose@creative.es',
                'foto'           => 'https://randomuser.me/api/portraits/men/12.jpg',
                'rol_id'         => 3,
                'password'       => Hash::make('12345678'),
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'usuario_id'     => 4,
                'nombre'         => 'Laura Gómez',
                'nombre_usuario' => 'laura@creative.es',
                'foto'           => 'https://randomuser.me/api/portraits/women/15.jpg',
                'rol_id'         => 3,
                'password'       => Hash::make('12345678'),
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);
    }
}
