import { Routes } from '@angular/router';

//Importamos componentes
import { InicioComponent } from './pages/inicio/inicio.component';
import { LoginComponent } from './pages/login/login.component';
import { PerfilComponent } from './pages/perfil/perfil.component';
import { ProductosComponent } from './pages/productos/productos.component';
import { ProductoDetalleComponent } from './pages/producto-detalle/producto-detalle.component';
import { CarritoComponent } from './pages/carrito/carrito.component';
import { RegistroComponent } from './pages/registro/registro.component';

import { authGuard } from './auth.guard'; 

export const routes: Routes = [
  
  
  { 
    path: '', 
    component: InicioComponent, 
    title: 'Inicio | Creative Eye'
  },

  { 
    path: 'login', 
    component: LoginComponent,
    title: 'Acceso | Creative Eye'
  },

  {
    path: 'perfil', 
    component: PerfilComponent,
    canActivate: [ authGuard ],
    title: 'Mi Perfil | Creative Eye'
  },

  {
    path: 'productos', 
    component: ProductosComponent,
    title: 'Tienda | Creative Eye'
  },

  {
    path: 'producto/:id', 
    component: ProductoDetalleComponent,
    title: 'Detalle del Producto | Creative Eye'
  },

  {
    path: 'carrito', 
    component: CarritoComponent,
    title: 'Mi Carrito | Creative Eye'
  },

  {
    path: 'registro',
    component: RegistroComponent,
    title: 'Registro | Creative Eye'
  },

];