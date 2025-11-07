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
        // Si el usuario no está autenticado
        if (!$user) {
            return response()->json(['message' => 'No autenticado.'], 401);
        }

        // Si su rol NO está en los roles permitidos
        if (!in_array($user->rol_id, $roles)) {
            return response()->json(['message' => 'Acceso denegado.'], 403);
        }

        // Si todo está bien, continúa con la petición

        return $next($request);
    }
}
