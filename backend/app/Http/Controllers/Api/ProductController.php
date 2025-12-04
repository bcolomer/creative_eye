<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

/**
 * @OA\Tag(
 *     name="Productos",
 *     description="Gestión de productos (públicos para visualización, privados para CRUD por roles de almacén o administrador)"
 * )
 */
class ProductController extends Controller
{
    /**
     * Muestra la lista de productos.
     *
     * @OA\Get(
     * path="/api/products",
     * summary="Listar todos los productos",
     * description="Devuelve un array con todos los productos y sus categorías asociadas. Endpoint público.",
     * tags={"Productos"},
     * @OA\Response(
     * response=200,
     * description="Lista de productos recuperada correctamente",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="producto_id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Fujifilm X-T5"),
     * @OA\Property(property="precio", type="number", format="float", example=1899.99),
     * @OA\Property(property="cantidad", type="integer", example=10),
     * @OA\Property(property="foto", type="string", example="http://.../foto.jpg"),
     * @OA\Property(property="categoria_id", type="integer", example=5),
     * @OA\Property(
     * property="categoria",
     * type="object",
     * nullable=true,
     * description="Datos de la categoría asociada",
     * @OA\Property(property="categoria_id", type="integer", example=5),
     * @OA\Property(property="nombre", type="string", example="Cámaras")
     * )
     * )
     * )
     * )
     * )
     */
    // GET /api/products
    public function index()
    {
        // Traemos todos los productos con su categoría cargada
        $products = Product::with('categoria')->get();

        return response()->json($products);
    }

    /**
     * Guarda nuevo producto.
     *
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crear un nuevo producto",
     *     description="Crea un nuevo producto en la base de datos. **Solo accesible para roles de Almacén o Administrador.**",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","precio","cantidad","codigo"},
     *             @OA\Property(property="nombre", type="string", example="Tarjeta Sd"),
     *             @OA\Property(property="precio", type="number", example=89.90),
     *             @OA\Property(property="cantidad", type="integer", example=15),
     *             @OA\Property(property="codigo", type="string", example="LPM-002"),
     *             @OA\Property(property="categoria_id", type="integer", example=2),
     *             @OA\Property(property="foto", type="string", example="https://example.com/tarjeta.jpg"),
     *             @OA\Property(property="descripcion", type="string", example="tarjeta sd 4tb")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Producto creado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
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
     * Muestra un producto específico.
     *
     * @OA\Get(
     * path="/api/products/{producto_id}",
     * summary="Mostrar un producto específico",
     * description="Devuelve la información detallada de un producto y su categoría asociada.",
     * tags={"Productos"},
     * @OA\Parameter(
     * name="producto_id",
     * in="path",
     * required=true,
     * description="ID del producto a consultar",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\Response(
     * response=200,
     * description="Producto encontrado",
     * @OA\JsonContent(
     * @OA\Property(property="producto_id", type="integer", example=1),
     * @OA\Property(property="nombre", type="string", example="Fujifilm X-T5"),
     * @OA\Property(property="precio", type="number", format="float", example=1899.99),
     * @OA\Property(property="foto", type="string", example="http://.../foto.jpg"),
     * @OA\Property(property="categoria_id", type="integer", example=5),
     * @OA\Property(
     * property="categoria",
     * type="object",
     * description="Objeto con la información de la categoría",
     * nullable=true,
     * @OA\Property(property="categoria_id", type="integer", example=5),
     * @OA\Property(property="nombre", type="string", example="Cámaras")
     * )
     * )
     * ),
     * @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    // GET /api/products/{producto_id}
    public function show($id)
    {
        // Cargamos el producto CON la categoría
        $product = Product::with('categoria')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($product);
    }

    /**
     * Actualiza producto de almacén.
     *
     * @OA\Put(
     *     path="/api/products/{producto_id}",
     *     summary="Actualizar un producto",
     *     description="Permite modificar los datos de un producto existente. **Solo accesible para roles de Almacén o Administrador.**",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="producto_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Lámpara LED actualizada"),
     *             @OA\Property(property="precio", type="number", example=59.99),
     *             @OA\Property(property="cantidad", type="integer", example=30),
     *             @OA\Property(property="foto", type="string", example="https://example.com/lampara-nueva.jpg"),
     *             @OA\Property(property="descripcion", type="string", example="Lámpara con nuevo diseño y más brillo.")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Producto actualizado correctamente"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    // PUT /api/products/{producto_id}
    public function update(Request $request, $producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => __('api.product_not_found')], 404);
        }

        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * Elimina producto de almacén.
     *
     * @OA\Delete(
     *     path="/api/products/{producto_id}",
     *     summary="Eliminar un producto",
     *     description="Elimina un producto del catálogo. **Solo accesible para roles de Almacén o Administrador.**",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="producto_id",
     *         in="path",
     *         required=true,
     *         description="ID del producto a eliminar",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(response=200, description="Producto eliminado correctamente"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    // DELETE /api/products/{producto_id}
    public function destroy($producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => __('api.product_not_found')], 404);
        }

        $product->delete();
        return response()->json(['message' => __('api.product_deleted')], 200);
    }
}
