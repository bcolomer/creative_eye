<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/SetLocale.php
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // Obtenemos el idioma preferido del navegador, limitado a los que soportamos ('es', 'en')
            $browserLocale = $request->getPreferredLanguage(['es', 'en']);

            if (in_array($browserLocale, ['es', 'en'])) {
                // Si el navegador pide un idioma que soportamos, lo aplicamos.
                App::setLocale($browserLocale);
            } else {
                // Idioma por defecto de la aplicación ('es')
                App::setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}
