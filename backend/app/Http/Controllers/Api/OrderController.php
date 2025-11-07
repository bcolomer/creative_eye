<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Pedidos",
 *     description="Gestión de pedidos: creación, consulta, actualización y eliminación de pedidos.
 *     - Los usuarios con rol **Almacén** pueden gestionar todos los pedidos.
 *     - Los usuarios con rol **Administrador** o **Cliente** pueden consultar únicamente los suyos."
 * )
 */
class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Listar todos los pedidos",
     *     description="Muestra todos los pedidos con su usuario y productos asociados.
     *     <b>Solo accesible por roles de Almacén.</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pedidos",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="pedido_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=5),
     *             @OA\Property(property="total_pedido", type="number", example=149.99),
     *             @OA\Property(property="fecha_pedido", type="string", example="2025-11-07")
     *         ))
     *     ),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */
    // Lista Pedidos convierte ids en usuario y producto respectivamente
    public function index()
    {
        $pedidos = Order::with('usuario', 'productos')->get();
        return response()->json($pedidos);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Crear un nuevo pedido",
     *     description="Permite crear un pedido con uno o varios productos.
     *     Cada item debe incluir `producto_id` y `cantidad`.
     *     <b>Solo accesible para usuarios autenticados (Cliente o Administrador).</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"items"},
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="producto_id", type="integer", example=2),
     *                     @OA\Property(property="cantidad", type="integer", example=3)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pedido creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pedido creado correctamente"),
     *             @OA\Property(property="pedido", type="object",
     *                 @OA\Property(property="pedido_id", type="integer", example=5),
     *                 @OA\Property(property="usuario_id", type="integer", example=7),
     *                 @OA\Property(property="total_pedido", type="number", example=199.99),
     *                 @OA\Property(property="fecha_pedido", type="string", example="2025-11-07")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Usuario no autenticado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    // Añade un pedido
    public function store(Request $request)
    { //         Usuario autenticado por Sanctum (token)
        $user = $request->user();
        // Si no hay usuario autenticado, devolvemos error 401
        if (!$user) {
            // Mensaje de debug temporal para saber qué está pasando
            return response()->json([
                'message' => 'Usuario no autenticado',
                'headers' => $request->header('Authorization'),
            ], 401);
        }

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,producto_id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $producto = Product::find($item['producto_id']);
                $total += $producto->precio * $item['cantidad'];
            }

            $pedido = Order::create([
                'usuario_id'   => $user->usuario_id,
                'fecha_pedido' => now()->toDateString(),
                'total_pedido' => $total,
            ]);

            foreach ($validated['items'] as $item) {
                $producto = Product::find($item['producto_id']);

                OrderProduct::create([
                    'pedido_id'       => $pedido->pedido_id,
                    'producto_id'     => $producto->producto_id,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'precio_total'    => $producto->precio * $item['cantidad'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pedido creado correctamente',
                'pedido'  => $pedido->load('usuario', 'productos'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en store OrderController: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al crear el pedido',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Mostrar un pedido específico",
     *     description="Devuelve un pedido con su usuario y productos asociados.
     *     <b>Solo accesible para el rol de Almacén.</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del pedido",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(response=200, description="Pedido encontrado"),
     *     @OA\Response(response=404, description="Pedido no encontrado")
     * )
     */
    public function show($id)
    {
        $pedido = Order::with('usuario', 'productos')->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido);
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Actualizar un pedido",
     *     description="Permite modificar un pedido existente.
     *     <b>Solo accesible para el rol de Almacén.</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="usuario_id", type="integer", example=2),
     *             @OA\Property(property="fecha_pedido", type="string", example="2025-11-07"),
     *             @OA\Property(property="total_pedido", type="number", example=89.90)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pedido actualizado correctamente"),
     *     @OA\Response(response=404, description="Pedido no encontrado")
     * )
     */
    // Modifica pedido
    public function update(Request $request, $id)
    {
        $pedido = Order::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $validated = $request->validate([
            'usuario_id' => 'sometimes|required|exists:usuarios,usuario_id',
            'fecha_pedido' => 'sometimes|required|date',
            'total_pedido' => 'sometimes|required|numeric|min:0',
        ]);

        $pedido->update($validated);

        return response()->json([
            'message' => 'Pedido actualizado correctamente',
            'pedido' => $pedido,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Eliminar un pedido",
     *     description="Elimina un pedido existente.
     *     <b>Solo accesible para el rol de Almacén.</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(response=200, description="Pedido eliminado correctamente"),
     *     @OA\Response(response=404, description="Pedido no encontrado")
     * )
     */
    // Elimina pedido
    public function destroy($id)
    {
        $pedido = Order::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado correctamente']);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/my",
     *     summary="Listar pedidos del usuario autenticado",
     *     description="Devuelve todos los pedidos del usuario autenticado junto con sus productos.
     *     <b>Accesible para Administrador y Cliente (solo sus propios pedidos).</b>",
     *     tags={"Pedidos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Pedidos del usuario autenticado"),
     *     @OA\Response(response=404, description="No se encontraron pedidos para este usuario"),
     *     @OA\Response(response=401, description="Usuario no autenticado")
     * )
     */
    // Pedidos del usuario autenticado
    public function myOrders(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $orders = $user->pedidos()->with(['productos'])->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No se encontraron pedidos para este usuario'], 404);
        }

        return response()->json($orders);
    }
}
