import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, BehaviorSubject, tap } from 'rxjs';
import { Router } from '@angular/router';
import { CartService } from './cart.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = 'http://127.0.0.1:8000/api';

  // Inicializamos leyendo del localStorage para no perder el estado al recargar
  private userSubject = new BehaviorSubject<any>(this.getUserFromStorage());
  
  // Observable público al que se suscriben los componentes (Header, etc.)
  public user$ = this.userSubject.asObservable();

  constructor(
    private http: HttpClient,
    private router: Router,
    private cartService: CartService
  ) { }

  /**
   * Helper para recuperar usuario del storage de forma segura
   */
  private getUserFromStorage(): any {
    const userStr = localStorage.getItem('user');
    try {
      return userStr ? JSON.parse(userStr) : null;
    } catch (e) {
      return null;
    }
  }

  /**
   * Iniciar sesión
   */
  login(datos: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/login`, datos).pipe(
      tap((res: any) => {
        // GUARDAMOS EL TOKEN PRIMERO (para que la foto cargue)
        if (res.token) {
            localStorage.setItem('token', res.token);
        }
        
        // Guardamos el usuario y avisamos a la app
        if (res.user) {
          localStorage.setItem('user', JSON.stringify(res.user));
          this.userSubject.next(res.user);
        }
      })
    );
  }

  /**
   * Obtener perfil actualizado
   */
  getProfile(): Observable<any> {
    return this.http.get(`${this.apiUrl}/profile`).pipe(
      tap((user: any) => {
        // Actualizamos localStorage y avisamos a la app
        localStorage.setItem('user', JSON.stringify(user));
        this.userSubject.next(user);
      })
    );
  }

  /**
   * Verifica si hay sesión activa
   */
  isLoggedIn(): boolean {
    const token = localStorage.getItem('token');
    return (token !== null) && (token.length > 0);
  }

  /**
   * Cerrar sesión
   */
  logout(): void {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    
    // Limpiamos carrito y estado de usuario
    this.cartService.clearCart();
    this.userSubject.next(null);

    console.log('Cerrando sesión global...');
    window.location.href = 'http://127.0.0.1:8000/logout-sso';
  }

  /**
   * Registro de usuario
   */
  register(datos: any): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };
    return this.http.post(`${this.apiUrl}/register`, datos, httpOptions);
  }

  /**
   * Actualizar perfil (Nombre, Email, Foto, Contraseña)
   */
  updateProfile(datos: any, fotoFile?: File): Observable<any> {
    const formData = new FormData();

    // Campos básicos
    formData.append('nombre', datos.nombre);
    if (datos.nombre_usuario) {
        formData.append('nombre_usuario', datos.nombre_usuario);
    }

    // Contraseñas (si vienen)
    if (datos.current_password) {
        formData.append('current_password', datos.current_password);
    }
    if (datos.password) {
        formData.append('password', datos.password);
    }

    if (datos.password_confirmation) {
        formData.append('password_confirmation', datos.password_confirmation);
    }
    // Foto
    if (fotoFile) {
        formData.append('foto', fotoFile);
    }

    // Laravel requiere esto para PUT con FormData
    formData.append('_method', 'PUT');

    return this.http.post(`${this.apiUrl}/profile`, formData).pipe(
        tap((res: any) => {
            // Si la API devuelve el usuario actualizado, notificamos
            if (res.user) {
                localStorage.setItem('user', JSON.stringify(res.user));
                this.userSubject.next(res.user);
            }
        })
    );
  }

  /**
   * Roles
   */
  isAdmin(): boolean {
    const user = this.getUserFromStorage();
    return user && user.rol_id === 1;
  }

  isAlmacen(): boolean {
    const user = this.getUserFromStorage();
    return user && user.rol_id === 2;
  }

  getCurrentUser(): any {
    return this.getUserFromStorage();
  }

  /**
   * Obtener imagen protegida
   */
  getProfileImage(fileName: string): Observable<Blob> {
    return this.http.get(`${this.apiUrl}/profile/photo/${fileName}`, { responseType: 'blob' });
  }
}