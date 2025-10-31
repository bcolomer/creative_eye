<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/products
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // POST /api/products
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'codigo' => 'required|string',
            'categoria_id' => 'nullable|integer',
            'foto' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    // GET /api/products/{producto_id}
    public function show($producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /api/products/{producto_id}
    public function update(Request $request, $producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    // DELETE /api/products/{producto_id}
    public function destroy($producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
