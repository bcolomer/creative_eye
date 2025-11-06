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
// Ruta pública: REGISTRO
Route::post('/register', [AuthController::class, 'register']);


// Perfil del usuario autenticado
Route::middleware(['auth:sanctum'])->group(function () {

    // Ruta protegida: LOGOUT (requiere token)
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    // Ver los pedidos del usuario autenticado
    Route::get('/orders/my', [OrderController::class, 'myOrders']);
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


// Ruta opcional de resumen de pedidos (para estadísticas del almacen)
// Route::get('/orders/summary', [OrderController::class, 'summary']);
