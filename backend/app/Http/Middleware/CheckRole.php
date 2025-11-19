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

            // Si la petición espera una respuesta JSON (es decir, viene de Angular o Postman/Swagger),
            // devolvemos el JSON 403.
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso denegado.'], 403);
            }

            // Si es una petición normal de navegador (rutas web), forzamos el error de Blade.
            abort(403, 'Acceso denegado. No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
