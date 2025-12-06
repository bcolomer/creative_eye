<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\File as LaravelFile;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpieza
        Storage::disk('profile_private')->delete(Storage::disk('profile_private')->allFiles());

        $now = now();
        $password = Hash::make('12345678');

        // 2. Definición MANUAL de usuarios y sus fotos
        $usuarios = [
            [
                'usuario_id' => 1,
                'nombre' => 'Administrador',
                'nombre_usuario' => 'admin@creative.es',
                'rol_id' => 1,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-03.jpg'
            ],
            [
                'usuario_id' => 2,
                'nombre' => 'Responsable Almacén',
                'nombre_usuario' => 'almacen@creative.es',
                'rol_id' => 2,
                'genero' => 'mujeres',
                'foto_origen' => 'mujer-11.jpg'
            ],
            [
                'usuario_id' => 3,
                'nombre' => 'José Fernández',
                'nombre_usuario' => 'jose@creative.es',
                'rol_id' => 3,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-06.jpg'
            ],
            [
                'usuario_id' => 4,
                'nombre' => 'Laura Gómez',
                'nombre_usuario' => 'laura@creative.es',
                'rol_id' => 3,
                'genero' => 'mujeres',
                'foto_origen' => 'mujer-09.jpg'
            ],
            [
                'usuario_id' => 5,
                'nombre' => 'Juan Palomo',
                'nombre_usuario' => 'juan@administrador.com',
                'rol_id' => 1,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-07.jpg'
            ],
            [
                'usuario_id' => 6,
                'nombre' => 'José Gomez',
                'nombre_usuario' => 'jose@almacen.com',
                'rol_id' => 2,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-04.jpg'
            ],
            [
                'usuario_id' => 7,
                'nombre' => 'Pedro Navaja',
                'nombre_usuario' => 'pedro@cliente.com',
                'rol_id' => 3,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-02.jpg'
            ],
            [
                'usuario_id' => 8,
                'nombre' => 'Carlos Gomez',
                'nombre_usuario' => 'carlitos@cliente.com',
                'rol_id' => 3,
                'genero' => 'hombres',
                'foto_origen' => 'hombre-01.jpg'
            ],
            [
                'usuario_id' => 9,
                'nombre' => 'Letizia Mallorca',
                'nombre_usuario' => 'leti@cliente.com',
                'rol_id' => 3,
                'genero' => 'mujeres',
                'foto_origen' => 'mujer-02.jpg'
            ],
            [
                'usuario_id' => 10,
                'nombre' => 'Carolina Papaleo',
                'nombre_usuario' => 'carol@cliente.com',
                'rol_id' => 3,
                'genero' => 'mujeres',
                'foto_origen' => 'mujer-03.jpg'
            ],
            [
                'usuario_id' => 11,
                'nombre' => 'Eva Gonzalez',
                'nombre_usuario' => 'eva@cliente.com',
                'rol_id' => 3,
                'genero' => 'mujeres',
                'foto_origen' => 'mujer-05.jpg'
            ],
        ];

        foreach ($usuarios as $user) {
            // Buscamos la foto específica
            $fotoPath = $this->obtenerFotoEspecifica($user['genero'], $user['foto_origen'] ?? null);

            DB::table('usuarios')->insert([
                'usuario_id'     => $user['usuario_id'],
                'nombre'         => $user['nombre'],
                'nombre_usuario' => $user['nombre_usuario'],
                'foto'           => $fotoPath,
                'rol_id'         => $user['rol_id'],
                'password'       => $password,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }

    private function obtenerFotoEspecifica($carpetaGenero, $nombreArchivo)
    {
        // Si no definimos nombre de archivo, devolvemos null
        if (!$nombreArchivo) {
            return null;
        }

        // Ruta completa al archivo específico
        $rutaCompleta = database_path("seeders/img_profiles/$carpetaGenero/$nombreArchivo");

        // Si el archivo no existe, avisamos en consola y devolvemos null
        if (!File::exists($rutaCompleta)) {
            $this->command->warn("FOTO NO ENCONTRADA: $nombreArchivo en $carpetaGenero. Se usará el logo por defecto.");
            return null;
        }

        // Convertir y guardar en disco privado
        $archivoLaravel = new LaravelFile($rutaCompleta);
        return Storage::disk('profile_private')->putFile('', $archivoLaravel);
    }
}
