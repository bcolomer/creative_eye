<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderProductController;
use App\Http\Controllers\Api\ProfileController;


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

// Perfil del usuario autenticado
Route::middleware(['auth:sanctum'])->group(function () {

    // Ruta protegida: LOGOUT (requiere token)
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    //Ruta Pedidos
    Route::apiResource('orders', OrderController::class);
});



//Ruta Productos
Route::apiResource('products', ProductController::class);

//Ruta Categorias
Route::apiResource('categories', CategoryController::class);

//Ruta Roles
Route::apiResource('roles', RoleController::class);

//Ruta Usuarios
Route::apiResource('users', UserController::class);



//Ruta PedidosProductos
Route::apiResource('order-products', OrderProductController::class);
