<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Sistema",
 *     description="Rutas de comprobación del estado del servidor"
 * )
 */
class HealthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/health",
     *     summary="Verifica el estado del servidor",
     *     description="Devuelve información básica del entorno y la versión de Laravel.",
     *     tags={"Sistema"},
     *     @OA\Response(
     *         response=200,
     *         description="API operativa",
     *         @OA\JsonContent(
     *             @OA\Property(property="ok", type="boolean", example=true),
     *             @OA\Property(property="app", type="string", example="API Tienda"),
     *             @OA\Property(property="env", type="string", example="local"),
     *             @OA\Property(property="laravel", type="string", example="11.x"),
     *             @OA\Property(property="time", type="string", example="2025-11-07T15:32:00Z")
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        return response()->json([
            'ok' => true,
            'app' => config('app.name'),
            'env' => config('app.env'),
            'laravel' => app()->version(),
            'time' => now()->toISOString(),
        ]);
    }
}
