import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http'; 
//Con esto manejamos las respuestas
import { Observable } from 'rxjs';

import { Router } from '@angular/router';
import { CartService } from './cart.service';


@Injectable({
  providedIn: 'root'
})

export class AuthService {

  
  private apiUrl = '/api'; 

  
  constructor(
    private http: HttpClient,
    private router: Router,
    private cartService: CartService
  ) { }

  
  login(datos: any): Observable<any> {
    
    // Enviamos los datos (username y password) a la ruta /api/login
    return this.http.post(`${this.apiUrl}/login`, datos);
  }

  getProfile(): Observable<any> {
    // Esta llamada irá automáticamente con el token gracias al Interceptor
    return this.http.get(`${this.apiUrl}/profile`);
  }

  isLoggedIn(): boolean {
    // (!!) Convierte el resultado (un string o null) en un booleano (true/false)
    const token = localStorage.getItem('token');
    
    // Comprobamos que el token NO sea null Y que NO sea un string vacío.
    return (token !== null) && (token.length > 0);
  }

  // Añadimos el logout del usuario
  logout(): void {
    // Borramos el token de la memoria del navegador
    localStorage.removeItem('token');
    // Borramos la memoria del carrito para que no lo vea el siguiente usuario a loguearse
    this.cartService.clearCart();
    
    // Redirigimos al usuario a la página de inicio
    console.log('Sesión cerrada. ¡Hasta la próxima!');
    this.router.navigate(['/']); 
  }

  register(datos: any): Observable<any> {
    
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };

    // Enviamos a la ruta que Bárbara definió: /api/register
    return this.http.post(`${this.apiUrl}/register`, datos, httpOptions);
  }

}