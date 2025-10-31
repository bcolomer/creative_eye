<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

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
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,usuario_id',
            'fecha_pedido' => 'required|date',
            'total_pedido' => 'required|numeric|min:0',
        ]);

        $pedido = Order::create($validated);

        return response()->json([
            'message' => 'Pedido creado correctamente',
            'pedido' => $pedido,
        ], 201);
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
