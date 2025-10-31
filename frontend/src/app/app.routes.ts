import { Routes } from '@angular/router';

//Importamos componentes
import { InicioComponent } from './pages/inicio/inicio.component';
import { LoginComponent } from './pages/login/login.component';

import { authGuard } from './auth.guard'; 

export const routes: Routes = [
  
  
  { 
    path: '', // La ruta raíz
    component: InicioComponent 
  },
  { 
    path: 'login', // Con esto añadimos la ruta login http://localhost:4200/login
    component: LoginComponent 
  }


];