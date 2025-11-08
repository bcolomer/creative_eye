import { ApplicationConfig, provideZoneChangeDetection, LOCALE_ID } from '@angular/core';
import { provideRouter } from '@angular/router';

// 1. Importa las herramientas para interceptar
import { provideHttpClient, withInterceptors } from '@angular/common/http';

// 2. Importa el receptor
import { authInterceptor } from './interceptors/auth.interceptor';

import { routes } from './app.routes';

import { registerLocaleData } from '@angular/common';
import localeEs from '@angular/common/locales/es';

registerLocaleData(localeEs);

export const appConfig: ApplicationConfig = {
  providers: [
    provideZoneChangeDetection({ eventCoalescing: true }),
    provideRouter(routes),
    provideHttpClient(withInterceptors([authInterceptor])),
    { provide: LOCALE_ID, useValue: 'es-ES' }
  ]
};