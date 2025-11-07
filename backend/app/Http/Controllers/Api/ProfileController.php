<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Perfil",
 *     description="Operaciones relacionadas con el perfil del usuario autenticado"
 * )
 */
class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Obtener el perfil del usuario autenticado",
     *     description="Devuelve la información del usuario que ha iniciado sesión.
     *     Debes iniciar sesión primero (usa el token del endpoint `/api/login` y haz clic en **Authorize**).",
     *     tags={"Perfil"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Perfil obtenido correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="usuario_id", type="integer", example=5),
     *             @OA\Property(property="nombre", type="string", example="Juan Administrador"),
     *             @OA\Property(property="nombre_usuario", type="string", example="juan@administrador.com"),
     *             @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/men/33.jpg"),
     *             @OA\Property(property="rol_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */
    // GET /api/profile → muestra el usuario autenticado
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * @OA\Put(
     *     path="/api/profile",
     *     summary="Actualizar el perfil del usuario autenticado",
     *     description="Permite modificar los datos personales del usuario logueado.
     *     Se pueden enviar uno o varios campos, todos son opcionales.
     *     Si se envía `password`, debe incluir también `password_confirmation`.",
     *     tags={"Perfil"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan A. Pérez"),
     *             @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/men/40.jpg"),
     *             @OA\Property(property="password", type="string", example="123456789"),
     *             @OA\Property(property="password_confirmation", type="string", example="123456789")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Perfil actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Perfil actualizado correctamente"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="nombre", type="string", example="Juan A. Pérez"),
     *                 @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/men/40.jpg"),
     *                 @OA\Property(property="rol_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
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
