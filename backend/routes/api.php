<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

//Comprobar salud de la api
Route::get('/health', function () {
    return response()->json([
        'ok' => true,
        'app' => config('app.name'),
        'env' => config('app.env'),
        'laravel' => app()->version(),
        'time' => now()->toISOString(),
    ]);
});
// Ruta pública: LOGIN
Route::post('/login', [AuthController::class, 'login']);
//Route::post('/logout', [AuthController::class, 'logout']);

// Ruta protegida: LOGOUT (requiere token)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
