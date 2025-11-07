<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Gestión de usuarios del sistema (solo accesible para administradores)"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar todos los usuarios",
     *     description="Devuelve una lista con todos los usuarios del sistema junto con su rol.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida correctamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="usuario_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="nombre_usuario", type="string", example="juan@administrador.com"),
     *                 @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/men/22.jpg"),
     *                 @OA\Property(property="rol", type="object",
     *                     @OA\Property(property="rol_id", type="integer", example=1),
     *                     @OA\Property(property="nombre", type="string", example="Administrador")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    // lista los usuarios y realiza un join para darme el nombre del rol en lugar de la categoria
    public function index()
    {
        $usuarios = User::with('rol')->get();
        return response()->json($usuarios);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nuevo usuario",
     *     description="Crea un nuevo usuario en la base de datos.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","nombre_usuario","rol_id","password"},
     *             @OA\Property(property="nombre", type="string", example="Laura Gómez"),
     *             @OA\Property(property="nombre_usuario", type="string", example="laura@creative.es"),
     *             @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/women/12.jpg"),
     *             @OA\Property(property="rol_id", type="integer", example=3),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *             @OA\Property(property="usuario", type="object",
     *                 @OA\Property(property="usuario_id", type="integer", example=4),
     *                 @OA\Property(property="nombre", type="string", example="Laura Gómez"),
     *                 @OA\Property(property="nombre_usuario", type="string", example="laura@creative.es"),
     *                 @OA\Property(property="rol_id", type="integer", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    // Añade un usuario
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

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Mostrar un usuario específico",
     *     description="Devuelve los datos de un usuario, incluyendo su rol, según su ID.",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a consultar",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(response=200, description="Usuario encontrado"),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    // muestra un usuario
    public function show($id)
    {
        $usuario = User::with('rol')->find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualizar un usuario existente",
     *     description="Permite actualizar los datos de un usuario, incluyendo su rol o contraseña.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a actualizar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="José Fernández"),
     *             @OA\Property(property="foto", type="string", example="https://randomuser.me/api/portraits/men/12.jpg"),
     *             @OA\Property(property="rol_id", type="integer", example=2),
     *             @OA\Property(property="password", type="string", example="123456789")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario actualizado correctamente"),
     *     @OA\Response(response=404, description="Usuario no encontrado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    // Modifica un usuario
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

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminar un usuario",
     *     description="Elimina un usuario del sistema.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(response=200, description="Usuario eliminado correctamente"),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    // Elimina un usuario
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
