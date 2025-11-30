<?php

return [
    // --- ERRORES 404 (Página No Encontrada) ---
    '404_title' => 'Página No Encontrada',
    '404_header' => 'ERROR 404: PÁGINA NO ENCONTRADA',
    '404_info' => 'Lo sentimos, la URL a la que intentas acceder no existe en esta aplicación.',
    'go_back_prompt' => 'Puedes intentar volver al panel principal:',

    // --- ERRORES 403 (Acceso Denegado) ---
    '403_title' => 'Acceso Restringido',
    '403_header' => 'ERROR 403: ACCESO DENEGADO',
    '403_info' => 'No tienes los permisos necesarios para acceder a esta sección. (Tu rol no permite el acceso a este área, si crees que es un error comunicate con el responsable técnico).',
    '403_prompt' => '¿Quieres volver a la página principal o cerrar sesión?',

    // --- ERRORES 401 (No Autenticado) ---
    '401_title' => 'No Autenticado',
    '401_header' => 'ERROR 401: SESIÓN NO INICIADA',
    '401_info' => 'No has iniciado sesión o tu sesión ha expirado. Por favor, inicia sesión para acceder a esta página.',
    '401_prompt' => 'Para continuar, inicia sesión o vuelve a la página principal:',

    // --- BOTONES COMUNES DE ERROR ---
    'button_dashboard' => 'Ir al Dashboard',
    'button_home' => 'Volver a la Página Principal',
    'button_login' => 'Iniciar Sesión', // Solo se usa en el 401
];
