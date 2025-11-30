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
     * Muestra todos los productos.
     *
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar todos los productos",
     *     description="Devuelve un listado de todos los productos disponibles. Endpoint público (sin autenticación).",
     *     tags={"Productos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="producto_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Lámpara de escritorio"),
     *                 @OA\Property(property="precio", type="number", example=39.99),
     *                 @OA\Property(property="cantidad", type="integer", example=25),
     *                 @OA\Property(property="codigo", type="string", example="LPD-001"),
     *                 @OA\Property(property="categoria_id", type="integer", example=3),
     *                 @OA\Property(property="foto", type="string", example="https://example.com/lampara.jpg"),
     *                 @OA\Property(property="descripcion", type="string", example="Lámpara de escritorio LED con brazo flexible.")
     *             )
     *         )
     *     )
     * )
     */
    // GET /api/products
    public function index()
    {
        return Product::all();
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
     *             @OA\Property(property="nombre", type="string", example="Lámpara de pie moderna"),
     *             @OA\Property(property="precio", type="number", example=89.90),
     *             @OA\Property(property="cantidad", type="integer", example=15),
     *             @OA\Property(property="codigo", type="string", example="LPM-002"),
     *             @OA\Property(property="categoria_id", type="integer", example=2),
     *             @OA\Property(property="foto", type="string", example="https://example.com/lampara-pie.jpg"),
     *             @OA\Property(property="descripcion", type="string", example="Lámpara moderna con base metálica y luz cálida.")
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
     *     path="/api/products/{producto_id}",
     *     summary="Mostrar un producto específico",
     *     description="Devuelve la información detallada de un producto en función de su ID. Endpoint público.",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="producto_id",
     *         in="path",
     *         required=true,
     *         description="ID del producto a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Producto encontrado"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    // GET /api/products/{producto_id}
    public function show($producto_id)
    {
        $product = Product::where('producto_id', $producto_id)->first();

        if (!$product) {
            return response()->json(['message' => __('api.product_not_found')], 404);
        }

        return $product;
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
