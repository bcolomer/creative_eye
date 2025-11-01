<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        /* Validar los datos que llegan desde el frontend y revalida que el usuario sera un correo
        electronico rfcy que la contraseña tenga minimo 8 caracteres */
        $request->validate([
            'nombre_usuario' => 'required|email:rfc',
            'password' => 'required|string|min:8',
        ]);

        // Buscar el usuario por su nombre de usuario
        $user = User::where('nombre_usuario', $request->nombre_usuario)->first();

        // Si no existe o la contraseña no coincide
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        // borra todos los tokens anteriores
        $user->tokens()->delete();
        // Crear un nuevo token con Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver el token al frontend
        return response()->json([
            'message' => 'Inicio de sesión correcto',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        // Elimina todos los tokens del usuario autenticado
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
