<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Cambia el idioma de la aplicación y lo guarda en la sesión.
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    /*     public function setLanguage($locale)
    {
        $locales = ['es', 'en'];
        if (!in_array($locale, $locales)) {
            $locale = 'es'; // Si no es válido, vuelve a español por defecto
        }

        Session::put('locale', $locale);

        return redirect()->back();
    } */
    public function setLocale($locale)
    {
        // Lista de idiomas que soportamos
        $locales = ['es', 'en'];

        // Comprobación de seguridad: si el idioma no es válido, usamos 'es'
        if (!in_array($locale, $locales)) {
            $locale = 'es';
        }

        // 1. Guardamos la elección del usuario en la sesión
        Session::put('locale', $locale);

        // 2. Redirigimos al usuario a la página de donde vino
        return redirect()->back();
    }
}
