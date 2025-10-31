import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http'; 
//Con esto manejamos las respuestas
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class AuthService {

  
  private apiUrl = '/api'; 

  
  constructor(private http: HttpClient) { }

  
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
    return !!localStorage.getItem('token'); 
  }

}