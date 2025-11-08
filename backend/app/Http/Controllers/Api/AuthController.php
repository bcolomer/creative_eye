<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Autenticación",
 *     description="Endpoints para registro, login y cierre de sesión"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión",
     *     description="Permite al usuario autenticarse y obtener un token de acceso (Sanctum). Puedes usar cualquiera de los siguientes usuarios de prueba:
     *         - **Administrador:** juan@administrador.com / 12345678
     *         - **Almacén:** jose@almacen.com / 12345678
     *         - **Cliente:** pedro@cliente.com / 12345678",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Credenciales del usuario",
     *         @OA\JsonContent(
     *             required={"nombre_usuario","password"},
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="nombre_usuario", type="string", example="juan@administrador.com"),
     *                     @OA\Property(property="password", type="string", example="12345678")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="nombre_usuario", type="string", example="jose@almacen.com"),
     *                     @OA\Property(property="password", type="string", example="12345678")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="nombre_usuario", type="string", example="pedro@cliente.com"),
     *                     @OA\Property(property="password", type="string", example="12345678")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión correcto",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Inicio de sesión correcto"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="nombre", type="string", example="Juan Palomo"),
     *                 @OA\Property(property="nombre_usuario", type="string", example="juan@administrador.com"),
     *                 @OA\Property(property="rol_id", type="integer", example=1)
     *             ),
     *             @OA\Property(property="token", type="string", example="1|eyJhbGciOiJIUzI1...")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Credenciales incorrectas"),
     *     @OA\Response(response=422, description="Error de validación de datos")
     * )
     */
    public function login(Request $request)
    {
        /* Validar los datos que llegan desde el frontend y revalida que el usuario sera un correo
        electronico rfc y que la contraseña tenga minimo 8 caracteres */
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

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     description="Crea un nuevo usuario con rol de cliente (3) y devuelve su token de acceso",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del usuario a registrar",
     *         @OA\JsonContent(
     *             required={"nombre","nombre_usuario","password"},
     *             @OA\Property(property="nombre", type="string", example="Maria LaPaz"),
     *             @OA\Property(property="nombre_usuario", type="string", format="email", example="marialapaz@cliente.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario registrado correctamente"),
     *             @OA\Property(property="usuario", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="nombre", type="string", example="Maria LaPaz"),
     *                 @OA\Property(property="nombre_usuario", type="string", example="marialapaz@cliente.com"),
     *                 @OA\Property(property="rol_id", type="integer", example=3)
     *             ),
     *             @OA\Property(property="token", type="string", example="1|eyJhbGciOiJIUzI1...")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|email|max:255|unique:usuarios,nombre_usuario',
            'password' => 'required|string|min:8',
        ]);

        // Rol por defecto: cliente (3)
        $user = User::create([
            'nombre' => $validated['nombre'],
            'nombre_usuario' => $validated['nombre_usuario'],
            'password' => bcrypt($validated['password']),
            'rol_id' => 3,
            'foto' => '/images/creativelogo.png',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver el token al frontend
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'usuario' => $user,
            'token' => $token,
        ], 201);
    }



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión",
     *     description="Cierra la sesión del usuario autenticado y elimina su token",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */    public function logout(Request $request)
    {
        // Elimina todos los tokens del usuario autenticado
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
