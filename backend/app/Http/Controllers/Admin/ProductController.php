<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Muestra lista de productos.
     */
    public function index()
    {
        $productos = Product::all();
        /*   ide dice que es igual a poner esto: $productos = \App\Models\Product::all(); */

        return view('admin.productos.index', [
            'productos' => $productos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $producto)
    {
        return view('admin.productos.edit', [
            'producto' => $producto
        ]);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $producto)
    {
        // Validar los datos )
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'codigo' => 'required|string|max:255',
            'foto' => 'nullable|image|max:1024',
        ]);

        // Comprobar foto nueva
        if ($request->hasFile('foto')) {
            // (Opcional: borrar la foto antigua si existe)
            // if ($producto->foto) {
            //     Storage::disk('public')->delete(str_replace('/storage/', '', $producto->foto));
            // }

            // Guardar la nueva foto en 'storage/app/public/product-photos'
            $path = $request->file('foto')->store('product-photos', 'public');
            // Guardamos la ruta pública (ej. /storage/product-photos/imagen.jpg)
            $validated['foto'] = '/storage/' . $path;
        }

        // Actualizar el producto en la BBDD con los datos validados
        $producto->update($validated);


        return redirect()->route('productos.edit', $producto->producto_id)->with('status', '¡Producto actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
