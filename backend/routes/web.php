<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// --- RUTAS DE PERFIL (Para todos los logueados: Admin, Almacén, Cliente) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- RUTAS COMUNES DE PANEL (Admin y Almacén) ---
Route::middleware(['auth', 'verified', 'role:1,2'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// --- RUTAS DE ALMACÉN (Solo Rol 2) ---
Route::middleware(['auth', 'verified', 'role:2'])->group(function () {

    // Ruta de Productos
    Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
    // Edicion de Productos
    Route::get('/productos/{producto}/edit', [ProductController::class, 'edit'])->name('productos.edit');
    //  actualizar el producto
    Route::put('/productos/{producto}', [ProductController::class, 'update'])->name('productos.update');
});


require __DIR__ . '/auth.php';
