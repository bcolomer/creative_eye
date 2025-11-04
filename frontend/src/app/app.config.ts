import { ApplicationConfig, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';

// 1. Importa las herramientas para interceptar
import { provideHttpClient, withInterceptors } from '@angular/common/http';

// 2. Importa el receptor
import { authInterceptor } from './interceptors/auth.interceptor';

import { routes } from './app.routes';

export const appConfig: ApplicationConfig = {
  providers: [
    provideZoneChangeDetection({ eventCoalescing: true }),
    provideRouter(routes),
    
    // 3. Modifica esta línea
    // Antes: provideHttpClient()
    // Ahora:
    provideHttpClient(withInterceptors([authInterceptor]))
  ]
};