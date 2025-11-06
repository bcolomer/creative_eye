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

//RUTAS PUBLICAS (sin autenticacion)
//------------------------------------------------------------------------------------------
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

//  LOGIN
Route::post('/login', [AuthController::class, 'login']);
//  REGISTRO
Route::post('/register', [AuthController::class, 'register']);
// Productos y categorias visibles para todos
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);


//RUTAS PROTEGIDAS
//------------------------------------------------------------------------------------------
Route::middleware(['auth:sanctum'])->group(function () {

    // PERFIL (todos los roles)
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Ruta compartida (admin y cliente) — solo una definición
    Route::get('/orders/my', [OrderController::class, 'myOrders'])
        ->middleware('role:1,3'); // sólo admin (1) y cliente (3)

    //ADMINISTRADOR (rol_id = 1)
    Route::middleware(['role:1'])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('orders', OrderController::class)->except(['index']);
    });

    //ALMACEN (rol_id = 2)
    Route::middleware(['role:2'])->group(function () {
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::apiResource('order-products', OrderProductController::class);
    });

    //CLIENTE (rol_id = 3)
    Route::middleware(['role:3'])->group(function () {
        Route::apiResource('orders', OrderController::class)->except(['index']);
    });






    //Ruta PedidosProductos


    // Ruta opcional de resumen de pedidos (para estadísticas del almacen)
    // Route::get('/orders/summary', [OrderController::class, 'summary']);
});
