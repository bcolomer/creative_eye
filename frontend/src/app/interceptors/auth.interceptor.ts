import { HttpInterceptorFn } from '@angular/common/http';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  
  // 1. Coge el token de LocalStorage
  const authToken = localStorage.getItem('token');

  // 2. Comprueba si existe
  if (authToken) {
    // 3. Si existe, CLONAR la petición y AÑADIR la llave
    const authReq = req.clone({
      setHeaders: {
        Authorization: `Bearer ${authToken}`
      }
    });
    
    // 4. Dejar pasar la petición MODIFICADA
    return next(authReq);
  }

  // 5. Si no hay llave, dejar pasar la petición ORIGINAL
  return next(req);
};