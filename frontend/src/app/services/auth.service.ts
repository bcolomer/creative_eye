import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http'; 
//Con esto manejamos las respuestas
import { Observable } from 'rxjs';

import { Router } from '@angular/router';


@Injectable({
  providedIn: 'root'
})

export class AuthService {

  
  private apiUrl = '/api'; 

  
  constructor(
    private http: HttpClient,
    private router: Router
  ) { }

  
  login(datos: any): Observable<any> {
    
    // Enviamos los datos (username y password) a la ruta /api/login
    return this.http.post(`${this.apiUrl}/login`, datos);
  }

  getProfile(): Observable<any> {
    // Esta llamada irá automáticamente con el token gracias al Interceptor
    return this.http.get(`${this.apiUrl}/user`);
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
    
    // Redirigimos al usuario a la página de inicio
    console.log('Sesión cerrada. ¡Hasta la próxima!');
    this.router.navigate(['/']); 
  }

}