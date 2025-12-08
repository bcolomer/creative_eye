<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

// --- RUTAS DE PERFIL (Para todos los logueados: Admin, Almacén, Cliente) ---
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Ruta para ver la foto de perfil (usando sesión web)
    Route::get('/profile/photo/{fileName}', [ProfileController::class, 'showPhoto'])
        ->name('profile.photo');
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
    // crear producto
    Route::get('/productos/crear', [ProductController::class, 'create'])->name('productos.create');
    // Ruta para RECIBIR y GUARDAR el producto
    Route::post('/productos', [ProductController::class, 'store'])->name('productos.store');
    // Ruta para BORRAR el producto de la BBDD
    Route::delete('/productos/{producto}', [ProductController::class, 'destroy'])->name('productos.destroy');
});

// --- RUTAS DE ADMINISTRADOR (Solo Rol 1) ---
Route::middleware(['auth', 'verified', 'role:1'])->group(function () {

    // Lista de Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');

    //  Mostrar formulario para crear
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create');

    //  Guardar el nuevo usuario
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');

    // Edición de Usuario (Mostrar formulario)
    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');

    // Actualizar Usuario (Guardar cambios)
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('admin.usuarios.update');

    // Borrar Usuario
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');
});

// Esta ruta se llama desde Angular para matar la sesión de Blade
Route::get('/logout-sso', function () {
    // Cerrar la sesión Web (Blade)
    Auth::guard('web')->logout();

    // Invalidar la sesión de PHP
    Session::invalidate();
    Session::regenerateToken();

    // Si estamos en local, usará localhost:4200 por defecto
    $frontendUrl = env('FRONTEND_URL', 'http://localhost:4200');
    
    return redirect($frontendUrl . '/login');
    
    // Redirigir de vuelta al Frontend (Angular)
    // Cambia esta URL por la de tu proyecto Angular si es diferente (ej. localhost:4200)
    // return redirect('http://localhost:4200/login');
})->name('logout.sso');


// Ruta para cambiar el idioma con arrays por medio de botón como prueba para dashboard y welcome de Laravel
Route::get('language/{locale}', [LanguageController::class, 'setLanguage'])->name('lang.switch');

// Ruta para cambiar el idioma con json

Route::get('lang/{locale}', [LanguageController::class, 'setLocale'])->name('locale.set');
// --- SOLUCIÓN ERROR 419 ---
// Si alguien entra por la URL /logout, cerramos sesión limpiamente y redirigimos
Route::get('/logout', function () {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();
    return redirect('/login');
});

require __DIR__ . '/auth.php';
