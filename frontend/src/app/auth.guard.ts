import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './services/auth.service'; // Asegúrate que esta ruta sea correcta

/**
 * Este es el guardián de autenticación.
 * Decide si una ruta puede ser activada.
 */
export const authGuard: CanActivateFn = (route, state) => {
  
  // 1. Inyectamos los servicios que necesitamos
  const authService = inject(AuthService);
  const router = inject(Router);

  // 2. Comprobamos si el usuario está logueado
  if (authService.isLoggedIn()) {
    
    // Si isLoggedIn() devuelve true, dejamos pasar.
    console.log('Acceso PERMITIDO');
    return true;

  } else {
    
    // Si NO está logueado, le redirigimos a la página de login
    console.warn('Acceso denegado: vuelve a intentarlo');
    router.navigate(['/login']);
    
    // Y bloqueamos el acceso a la ruta que intentaba visitar
    return false; 
  }
};