<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

/**
 * @OA\Tag(
 *     name="Categorías",
 *     description="Gestión de categorías de productos (visualización pública y administración por roles)"
 * )
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Listar todas las categorías",
     *     description="Devuelve un listado con todas las categorías registradas. Endpoint público (no requiere autenticación).",
     *     tags={"Categorías"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Iluminación")
     *             )
     *         )
     *     )
     * )
     */
    //  GET /api/categories → Mostrar todas las categorías
    public function index()
    {
        $categories = Category::all(['categoria_id', 'nombre']);
        return response()->json($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Crear una nueva categoría",
     *     description="Permite crear una categoría nueva (requiere rol de **almacén** o **administrador**).
     *     Ejemplo: crear una categoría llamada `Iluminación`.",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Iluminación")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría creada correctamente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="categoria_id", type="integer", example=10),
     *                 @OA\Property(property="nombre", type="string", example="Iluminación")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=403, description="Prohibido - No autorizado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    //  POST /api/categories → Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $category
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Mostrar una categoría específica",
     *     description="Devuelve los datos de una categoría en función de su ID.
     *     Ejemplo: `/api/categories/1` devuelve la categoría 'Iluminación'.",
     *     tags={"Categorías"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Iluminación")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    //  GET /api/categories/{id} → Mostrar una categoría específica
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Actualizar una categoría existente",
     *     description="Permite modificar el nombre de una categoría (requiere rol de **almacén** o **administrador**).",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Iluminación interior")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría actualizada correctamente"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="categoria_id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Iluminación interior")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=404, description="Categoría no encontrada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    //  PUT /api/categories/{id} → Actualizar una categoría
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $category->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'data' => $category
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Eliminar una categoría",
     *     description="Elimina una categoría específica (solo **almacén** o **administrador**).
     *     Ejemplo: `/api/categories/10` eliminará la categoría Iluminación.",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría a eliminar",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría eliminada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    // DELETE /api/categories/{id} → Eliminar una categoría
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}
