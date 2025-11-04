<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // GET /api/profile → muestra el usuario autenticado
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // PUT /api/profile → actualiza datos del usuario autenticado
    public function update(Request $request)
    {
        $user = $request->user();

        // Validar campos que se pueden modificar
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'foto' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        // Actualizar campos permitidos
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $user,
        ], 200);
    }
}
