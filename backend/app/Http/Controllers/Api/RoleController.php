<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Muestra todos los roles.
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    //Crea un nuevo rol.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Este rol ya existe.',
        ]);

        $rol = Role::create($validatedData);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'rol' => $rol,
        ], 201);
    }



    //Muestra un rol por su ID.
    public function show($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol);
    }


    //Actualiza un rol existente.
    public function update(Request $request, $id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $rol->rol_id . ',rol_id',
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe otro rol con este nombre.',
        ]);

        $rol->update($validatedData);

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'rol' => $rol,
        ]);
    }

    // Elimina un rol.

    public function destroy($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $rol->delete();

        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
