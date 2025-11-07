<?php

namespace App\OpenApi;

/**
 * @OA\Get(
 *     path="/api/health",
 *     summary="Health check",
 *     tags={"System"},
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="ok", type="boolean", example=true),
 *             @OA\Property(property="app", type="string", example="CreativeEye Api"),
 *             @OA\Property(property="env", type="string", example="local"),
 *             @OA\Property(property="laravel", type="string", example="12.x"),
 *             @OA\Property(property="time", type="string", format="date-time", example="2025-11-06T21:00:00Z")
 *         )
 *     )
 * )
 */
class HealthDoc
{
    //
}
