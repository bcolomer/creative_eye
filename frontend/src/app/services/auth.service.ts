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

  /**
   * 
   * @param datos 
   * @returns 
   */
  login(datos: any): Observable<any> {
    
    // Enviamos los datos (username y password) a la ruta /api/login
    return this.http.post(`${this.apiUrl}/login`, datos);
  }

  /**
   * 
   * @returns 
   */
  getProfile(): Observable<any> {
    // Esta llamada irá automáticamente con el token gracias al Interceptor
    return this.http.get(`${this.apiUrl}/profile`);
  }

  /**
   * 
   * @returns 
   */
  isLoggedIn(): boolean {
    // (!!) Convierte el resultado (un string o null) en un booleano (true/false)
    const token = localStorage.getItem('token');
    
    // Comprobamos que el token NO sea null Y que NO sea un string vacío.
    return (token !== null) && (token.length > 0);
  }

  /**
   * Añadimos el logout del usuario
   */
  logout(): void {

    localStorage.removeItem('token');

    localStorage.removeItem('user'); 

    this.cartService.clearCart();
    
    console.log('Sesión cerrada. ¡Hasta la próxima!.');
    this.router.navigate(['/']); 
  }

  /**
   * 
   * @param datos 
   * @returns 
   */
  register(datos: any): Observable<any> {
    
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };

    // Enviamos a la ruta /api/register
    return this.http.post(`${this.apiUrl}/register`, datos, httpOptions);
  }

  /**
   * Actualiza los datos del perfil del usuario logueado y envía los datos modificados al backend.
   * @param datos 
   * @returns 
   */
  updateProfile(datos: any): Observable<any> {
    
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };
    
    return this.http.put(`${this.apiUrl}/profile`, datos, httpOptions);
  }

  /**
   * Comprueba si hay un usuario con rol administrador
   */
  isAdmin(): boolean {
    const userString = localStorage.getItem('user');
    
    if (userString) {
      try {
        const user = JSON.parse(userString);
        return user && user.rol_id === 1;
      } catch (e) {
        return false;
      }
    }
    return false;
  }

  /**
   * Comprueba si el usuario tiene rol de Almacén (rol_id === 2)
   */
  isAlmacen(): boolean {
    const userString = localStorage.getItem('user');
    
    if (userString) {
      try {
        const user = JSON.parse(userString);
        return user && user.rol_id === 2;
      } catch (e) {
        return false;
      }
    }
    return false;
  }

}