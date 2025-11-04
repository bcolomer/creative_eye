<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    //Lista Pedidos convierte ids en usuario y producto respectivamente
    public function index()
    {
        $pedidos = Order::with('usuario', 'productos')->get();
        return response()->json($pedidos);
    }

    //Añade  un pedido
    public function store(Request $request)
    { // Usuario autenticado por Sanctum (token)
        $user = $request->user();
        // Si no hay usuario autenticado, devolvemos error 401
        if (!$user) {
            // Mensaje de debug temporal para saber qué está pasando
            return response()->json([
                'message' => 'Usuario no autenticado',
                'headers' => $request->header('Authorization'),
            ], 401);
        }

        // Validamos que envíen items (producto + cantidad)
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,producto_id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);




        DB::beginTransaction();

        try {
            //  Calcular total del pedido recorriendo los items
            $total = 0;
            foreach ($validated['items'] as $item) {
                $producto = Product::find($item['producto_id']);
                $total += $producto->precio * $item['cantidad'];
            }

            //  Crear el pedido
            $pedido = Order::create([
                'usuario_id'   => $user->usuario_id,
                'fecha_pedido' => now()->toDateString(),
                'total_pedido' => $total,
            ]);

            //  Crear cada línea del pedido en pedidos_productos
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

            //  Devolver el pedido con productos
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


    public function show($id)
    {
        $pedido = Order::with('usuario', 'productos')->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json($pedido);
    }

    //Modifica pedido
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
}
