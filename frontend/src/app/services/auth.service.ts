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
    // Borramos el token de la memoria del navegador
    localStorage.removeItem('token');
    // Borramos la memoria del carrito para que no lo vea el siguiente usuario a loguearse
    this.cartService.clearCart();

    localStorage.removeItem('user'); 
    
        console.log('Cerrando sesión global...');

    window.location.href = 'http://127.0.0.1:8000/logout-sso'; 

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

    // Enviamos a la ruta que Bárbara definió: /api/register
    return this.http.post(`${this.apiUrl}/register`, datos, httpOptions);
  }

  /**
   * Permite subir foto usando FormData
   * @param datos Objeto con los campos de texto (nombre, nombre_usuario)
   * @param fotoFile (Opcional) El archivo de la foto seleccionada
   * @returns
   */
  updateProfile(datos: any, fotoFile?: File): Observable<any> {
    const formData = new FormData();

    // Añadimos campos de texto
    formData.append('nombre', datos.nombre);
    formData.append('nombre_usuario', datos.nombre_usuario);

    // Si hay foto, la adjuntamos
    if (fotoFile) {
        formData.append('foto', fotoFile);
    }

    
    // Laravel no procesa archivos en PUT directo, así que enviamos POST + _method=PUT
    formData.append('_method', 'PUT');

    // Enviamos como POST sin headers manuales
    return this.http.post(`${this.apiUrl}/profile`, formData);
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
  // Pide la imagen al servidor enviando el Token automáticamente
  getProfileImage(fileName: string): Observable<Blob> {
    return this.http.get(`${this.apiUrl}/profile/photo/${fileName}`, { responseType: 'blob' });
  }
}
