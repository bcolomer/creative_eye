import { Routes } from '@angular/router';

//Importamos componentes
import { InicioComponent } from './pages/inicio/inicio.component';
import { LoginComponent } from './pages/login/login.component';
import { PerfilComponent } from './pages/perfil/perfil.component';
import { ProductosComponent } from './pages/productos/productos.component';
import { ProductoDetalleComponent } from './pages/producto-detalle/producto-detalle.component';

import { authGuard } from './auth.guard'; 

export const routes: Routes = [
  
  
  { 
    path: '', // La ruta raíz
    component: InicioComponent 
  },

  { 
    path: 'login', // Ruta login http://localhost:4200/login
    component: LoginComponent 
  },

  {
    path: 'perfil', // Ruta perfil http://localhost:4200/perfil
    component: PerfilComponent,
    canActivate: [ authGuard ]
  },

  {
    path: 'productos', // Ruta productos http://localhost:4200/productos
    component: ProductosComponent
  },

  {
    // El ':id' es un parámetro. Angular lo entiende de forma interna y la clase ProductoDetalleComponent lo leera.
    path: 'producto/:id', 
    component: ProductoDetalleComponent
  }

];