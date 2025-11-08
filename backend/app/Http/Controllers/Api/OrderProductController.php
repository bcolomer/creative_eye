<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

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
     * path="/api/order-products",
     * summary="Listar los productos del carrito activo",
     * description="Devuelve los productos asociados al pedido en estado 'pendiente'
     * (carrito) del usuario autenticado.",
     * tags={"Detalles de Pedido"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Lista de productos en el carrito",
     * @OA\JsonContent(type="array", @OA\Items(
     * @OA\Property(property="producto_id", type="integer", example=3),
     * @OA\Property(property="cantidad", type="integer", example=2),
     * @OA\Property(property="precio_unitario", type="number", example=49.99)
     * ))
     * ),
     * @OA\Response(response=404, description="El usuario no tiene un carrito activo")
     * )
     */
public function index()
    {
        $user = Auth::user();

        // 1. Comprobamos el rol del usuario
        if ($user->rol_id == 2) { 
            // ----- ES ROL 2 (ALMACÉN) -----
            // (Esta es la lógica antigua que tenías)
            $detalles = OrderProduct::with(['pedido', 'producto'])->get();
            return response()->json($detalles);
        
        } else {
            // ----- ES ROL 1 (ADMIN) o ROL 3 (CLIENTE) -----
            
            // 2. Buscamos su "carrito activo" (un pedido 'pendiente')
            $carrito = Order::where('usuario_id', $user->usuario_id)
                            // ->where('estado', 'pendiente')
                            ->first(); // Obtenemos el primero (o null)

            // 3. Si no tiene un carrito activo, devolvemos una lista vacía
            if (!$carrito) {
                return response()->json([]); // ¡Importante! Devolver un array vacío
            }

            // 4. Si SÍ tiene carrito, devolvemos solo los productos de ESE carrito
            $detalles = OrderProduct::where('pedido_id', $carrito->pedido_id)
                                    ->with('producto') 
                                    ->get();

            return response()->json($detalles);
        }
    }

    /**
     * @OA\Post(
     * path="/api/order-products",
     * summary="Añadir un producto a un pedido (Carrito)",
     * description="Crea una nueva línea de pedido (o actualiza la cantidad)
     * para el 'carrito' (pedido pendiente) del usuario autenticado.",
     * tags={"Detalles de Pedido"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"producto_id","cantidad"},
     * @OA\Property(property="producto_id", type="integer", example=5),
     * @OA\Property(property="cantidad", type="integer", example=1)
     * )
     * ),
     * @OA\Response(response=201, description="Producto añadido/actualizado en el carrito"),
     * @OA\Response(response=422, description="Error de validación (ej. producto_id no existe)"),
     * @OA\Response(response=404, description="Producto no encontrado en BBDD")
     * )
     */
    public function store(Request $request){

    // Validamos SÓLO lo que el frontend nos envía
    $data = $request->validate([
        'producto_id' => 'required|exists:productos,producto_id',
        'cantidad' => 'required|integer|min:1',
    ]);

    // Obtenemos el usuario que está haciendo la petición
    $user = Auth::user();

    // Buscamos su "carrito activo" (un pedido 'pendiente') y si no tiene, se crea
    $carrito = Order::firstOrCreate(
        [
            'usuario_id' => $user->usuario_id,
            //'estado' => 'pendiente' 
        ],
        [
            'fecha' => now(), 
            'total' => 0      
        ]
    );

    // Buscamos el precio REAL del producto en la BBDD
    $producto = Product::find($data['producto_id']);
    if (!$producto) {
        return response()->json(['message' => 'Producto no encontrado en BBDD'], 404);
    }

    // Creamos (o actualizamos) la línea del carrito (Usamos updateOrCreate para evitar duplicados si se añade el mismo producto)
    $orderProduct = OrderProduct::updateOrCreate(
        [
            'pedido_id' => $carrito->pedido_id,
            'producto_id' => $producto->producto_id,
        ],
        [
            'cantidad' => $data['cantidad'],
            'precio_unitario' => $producto->precio,
            'precio_total' => $data['cantidad'] * $producto->precio
        ]
    );
    
    // $nuevoTotal = $carrito->orderProducts()->sum('precio_total');

    // Actualizamos el campo 'total' en la tabla 'pedidos'
    // $carrito->total = $nuevoTotal;
    // $carrito->save();

    return response()->json([
        'message' => 'Producto añadido al carrito correctamente',
        'detalle' => $orderProduct
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
