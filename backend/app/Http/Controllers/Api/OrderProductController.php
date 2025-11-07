<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;

/**
 * @OA\Tag(
 *     name="Detalles de Pedido",
 *     description="Gestión de productos asociados a un pedido (líneas del pedido)"
 * )
 */
class OrderProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/order-products",
     *     summary="Listar todos los detalles de pedidos",
     *     description="Devuelve todos los productos asociados a pedidos existentes.
     *     **Solo accesible para roles de Almacén o Administrador.**",
     *     tags={"Detalles de Pedido"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de detalles de pedidos",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="pedido_id", type="integer", example=1),
     *             @OA\Property(property="producto_id", type="integer", example=3),
     *             @OA\Property(property="cantidad", type="integer", example=2),
     *             @OA\Property(property="precio_unitario", type="number", example=49.99),
     *             @OA\Property(property="precio_total", type="number", example=99.98)
     *         ))
     *     )
     * )
     */
    // lista los pedidos de los productos
    public function index()
    {
        $detalles = OrderProduct::with(['pedido', 'producto'])->get();
        return response()->json($detalles);
    }

    /**
     * @OA\Post(
     *     path="/api/order-products",
     *     summary="Añadir un producto a un pedido",
     *     description="Crea una nueva línea de pedido con producto, cantidad y precio unitario.
     *     Calcula automáticamente el precio total antes de guardar.",
     *     tags={"Detalles de Pedido"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pedido_id","producto_id","cantidad","precio_unitario"},
     *             @OA\Property(property="pedido_id", type="integer", example=1),
     *             @OA\Property(property="producto_id", type="integer", example=5),
     *             @OA\Property(property="cantidad", type="integer", example=3),
     *             @OA\Property(property="precio_unitario", type="number", example=24.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto añadido al pedido correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Producto añadido al pedido correctamente"),
     *             @OA\Property(property="detalle", type="object",
     *                 @OA\Property(property="pedido_id", type="integer", example=1),
     *                 @OA\Property(property="producto_id", type="integer", example=5),
     *                 @OA\Property(property="cantidad", type="integer", example=3),
     *                 @OA\Property(property="precio_unitario", type="number", example=24.99),
     *                 @OA\Property(property="precio_total", type="number", example=74.97)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,pedido_id',
            'producto_id' => 'required|exists:productos,producto_id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        // Calcular el total antes de guardar
        $validated['precio_total'] = $validated['cantidad'] * $validated['precio_unitario'];

        $detalle = OrderProduct::create($validated);

        return response()->json([
            'message' => 'Producto añadido al pedido correctamente',
            'detalle' => $detalle,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/order-products/{id}",
     *     summary="Mostrar un detalle de pedido específico",
     *     description="Devuelve la información completa de una línea de pedido (pedido + producto).",
     *     tags={"Detalles de Pedido"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del detalle de pedido",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(response=200, description="Detalle encontrado"),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    // muestra un pedido
    public function show($id)
    {
        $detalle = OrderProduct::with(['pedido', 'producto'])->find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        return response()->json($detalle);
    }

    /**
     * @OA\Put(
     *     path="/api/order-products/{id}",
     *     summary="Actualizar un detalle de pedido",
     *     description="Permite modificar cantidad o precio unitario de una línea de pedido.
     *     Recalcula automáticamente el precio total.",
     *     tags={"Detalles de Pedido"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="cantidad", type="integer", example=2),
     *             @OA\Property(property="precio_unitario", type="number", example=59.90)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Detalle actualizado correctamente"),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    // modifica el pedido
    public function update(Request $request, $id)
    {
        $detalle = OrderProduct::find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        $validated = $request->validate([
            'cantidad' => 'sometimes|required|integer|min:1',
            'precio_unitario' => 'sometimes|required|numeric|min:0',
        ]);

        if (isset($validated['cantidad']) || isset($validated['precio_unitario'])) {
            $cantidad = $validated['cantidad'] ?? $detalle->cantidad;
            $precio_unitario = $validated['precio_unitario'] ?? $detalle->precio_unitario;
            $validated['precio_total'] = $cantidad * $precio_unitario;
        }

        $detalle->update($validated);

        return response()->json([
            'message' => 'Detalle actualizado correctamente',
            'detalle' => $detalle,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/order-products/{id}",
     *     summary="Eliminar un detalle de pedido",
     *     description="Elimina una línea de pedido específica (producto de un pedido).
     *     **Solo accesible por roles de Almacén o Administrador.**",
     *     tags={"Detalles de Pedido"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del detalle de pedido",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(response=200, description="Detalle eliminado correctamente"),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    // elimina el pedido
    public function destroy($id)
    {
        $detalle = OrderProduct::find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        $detalle->delete();

        return response()->json(['message' => 'Detalle eliminado correctamente']);
    }
}
