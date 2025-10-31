<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //  GET /api/categories → Mostrar todas las categorías
    public function index()
    {
        $categories = Category::all(['categoria_id', 'nombre']);
        return response()->json($categories);
    }

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

    //  GET /api/categories/{id} → Mostrar una categoría específica
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

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
