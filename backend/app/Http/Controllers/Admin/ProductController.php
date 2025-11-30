<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Muestra lista de productos.
     */
    public function index()
    {
        $productos = Product::paginate(5);
        /* $productos = Product::all();  */

        return view('admin.productos.index', [
            'productos' => $productos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario (el "paquete" $request)
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'codigo' => 'required|string|max:255|unique:productos,codigo',
            'foto' => 'nullable|image|max:1024',
        ]);

        // Comprobar si se ha subido una foto
        if ($request->hasFile('foto')) {
            // Guardar la nueva foto en 'storage/app/public/product-photos'
            $path = $request->file('foto')->store('product-photos', 'public');
            // Guardamos la ruta pública (ej. /storage/product-photos/imagen.jpg)
            $validated['foto'] = '/storage/' . $path;
        }

        // Crear el producto en la BBDD con los datos validados
        $producto = Product::create($validated);

        // Redirigir al usuario de vuelta a la lista de productos
        //    con un mensaje de éxito.
        return redirect()->route('productos.index')->with('status', __('producto.create_success'));
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


        return redirect()->route('productos.edit', $producto->producto_id)->with('status', __('producto.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $producto)
    {
        //  Comprobamos si la foto es un archivo local del storage
        if ($producto->foto && str_starts_with($producto->foto, '/storage/')) {
            // Convertimos '/storage/product-photos/foto.jpg' en 'product-photos/foto.jpg'
            $storagePath = str_replace('/storage/', '', $producto->foto);

            // Borramos el archivo físico
            Storage::disk('public')->delete($storagePath);
        }

        // Borramos el producto de la base de datos
        $producto->delete();

        return redirect()->route('productos.index')->with('status', __('producto.delete_success'));
    }
}
