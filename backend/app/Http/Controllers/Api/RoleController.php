<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

/**
 * @OA\Tag(
 *     name="Roles",
 *     description="Gestión de roles de usuario (solo accesible para administradores)"
 * )
 */
class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Listar todos los roles",
     *     description="Devuelve todos los roles disponibles en el sistema.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="rol_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Administrador")
     *             )
     *         )
     *     )
     * )
     */
    // Muestra todos los roles.
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Crear un nuevo rol",
     *     description="Permite crear un nuevo rol en el sistema.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Supervisor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol creado correctamente"),
     *             @OA\Property(property="rol", type="object",
     *                 @OA\Property(property="rol_id", type="integer", example=5),
     *                 @OA\Property(property="nombre", type="string", example="Supervisor")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    // Crea un nuevo rol.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
        ], [
            'nombre.required' => __('api.role_name_required'),
            'nombre.unique' => __('api.role_name_unique'),
        ]);

        $rol = Role::create($validatedData);

        return response()->json([
            'message' => __('api.role_created'),
            'rol' => $rol,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Mostrar un rol específico",
     *     description="Devuelve los datos de un rol según su ID.",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del rol a consultar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(response=200, description="Rol encontrado"),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
     */
    // Muestra un rol por su ID.
    public function show($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => __('api.role_not_found')], 404);
        }

        return response()->json($rol);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Actualizar un rol existente",
     *     description="Permite modificar el nombre de un rol existente.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del rol a actualizar",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Empleado")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Rol actualizado correctamente"),
     *     @OA\Response(response=404, description="Rol no encontrado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    // Actualiza un rol existente.
    public function update(Request $request, $id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => __('api.role_not_found')], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $rol->rol_id . ',rol_id',
        ], [
            'nombre.required' => __('api.role_name_required'),
            'nombre.unique' => __('api.role_name_unique_other'),
        ]);

        $rol->update($validatedData);

        return response()->json([
            'message' => __('api.role_updated'),
            'rol' => $rol,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Eliminar un rol",
     *     description="Elimina un rol existente del sistema.
     *     **Solo accesible para el rol Administrador.**",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del rol a eliminar",
     *         @OA\Schema(type="integer", example=4)
     *     ),
     *     @OA\Response(response=200, description="Rol eliminado correctamente"),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
     */
    // Elimina un rol.
    public function destroy($id)
    {
        $rol = Role::find($id);

        if (!$rol) {
            return response()->json(['message' => __('api.role_not_found')], 404);
        }

        $rol->delete();

        return response()->json(['message' => __('api.role_deleted')]);
    }
}
