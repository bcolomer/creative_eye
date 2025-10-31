<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // lista los usuarios y realiza un join para darme el nombre del rol en lugar de la categoria
    public function index()
    {
        $usuarios = User::with('rol')->get();
        return response()->json($usuarios);
    }

    //Añade un usuario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'foto' => 'nullable|string',
            'rol_id' => 'required|exists:roles,rol_id',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $usuario = User::create($validatedData);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario,
        ], 201);
    }

    //muestra un usuario
    public function show($id)
    {
        $usuario = User::with('rol')->find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    //Modifica un usuario
    public function update(Request $request, $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'nombre_usuario' => 'sometimes|required|string|max:255|unique:usuarios,nombre_usuario,' . $usuario->usuario_id . ',usuario_id',
            'foto' => 'nullable|string',
            'rol_id' => 'sometimes|required|exists:roles,rol_id',
            'password' => 'nullable|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $usuario->update($validatedData);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario,
        ]);
    }
    //Elimina un usuario
    public function destroy($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
