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

    // Redirigimos al usuario a la página de inicio
    console.log('Sesión cerrada. ¡Hasta la próxima!');
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

    // Enviamos a la ruta que Bárbara definió: /api/register
    return this.http.post(`${this.apiUrl}/register`, datos, httpOptions);
  }

  /**
   * Actualiza los datos del perfil del usuario logueado y envía los datos modificados al backend.
   * @param datos
   * @returns
   */
  // =========================================================
  //  MODIFICACIÓN PARA SUBIR FOTO AL BACKEND (STORAGE PRIVADO)
  // =========================================================

  /* // ESTA ES LA FUNCIÓN ANTIGUA (Comentada por seguridad)
  updateProfile(datos: any): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };
    return this.http.put(`${this.apiUrl}/profile`, datos, httpOptions);
  }
  */

  /**
   * NUEVA VERSIÓN: Permite subir foto usando FormData
   * @param datos Objeto con los campos de texto (nombre, nombre_usuario)
   * @param fotoFile (Opcional) El archivo de la foto seleccionada
   */
  updateProfile(datos: any, fotoFile?: File): Observable<any> {
    const formData = new FormData();

    // 1. Añadimos campos de texto
    formData.append('nombre', datos.nombre);
    formData.append('nombre_usuario', datos.nombre_usuario);

    // 2. Si hay foto, la adjuntamos
    if (fotoFile) {
        formData.append('foto', fotoFile);
    }

    // 3. TRUCO DE LARAVEL: Method Spoofing
    // Laravel no procesa archivos en PUT directo, así que enviamos POST + _method=PUT
    formData.append('_method', 'PUT');

    // 4. Enviamos como POST sin headers manuales (Angular lo gestiona)
    return this.http.post(`${this.apiUrl}/profile`, formData);
  }
// Pide la imagen al servidor enviando el Token automáticamente
  getProfileImage(fileName: string): Observable<Blob> {
    return this.http.get(`${this.apiUrl}/profile/photo/${fileName}`, { responseType: 'blob' });
  }
}
