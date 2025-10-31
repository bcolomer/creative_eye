<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;

class OrderProductController extends Controller
{
    //lista los pedidos de los productos
    public function index()
    {
        $detalles = OrderProduct::with(['pedido', 'producto'])->get();
        return response()->json($detalles);
    }


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

    //muestra un pedido

    public function show($id)
    {
        $detalle = OrderProduct::with(['pedido', 'producto'])->find($id);

        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        return response()->json($detalle);
    }

    //modifica el pedido
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

    //elimina el pedido
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
