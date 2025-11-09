<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja solicitudes entrantes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    $user = $request->user();

    // Si no está autenticado
    if (!$user) {
        return response()->json(['message' => 'No autenticado.'], 401);
    }

 
    $allowedRoles = collect($roles)
        ->flatMap(fn($r) => explode(',', $r)) 
        ->map(fn($r) => (int)$r)              
        ->toArray();

    // Verificar si el rol del usuario está permitido
    if (!in_array($user->rol_id, $allowedRoles)) {
        return response()->json(['message' => 'Acceso denegado.'], 403);
    }

    return $next($request);
}

}
