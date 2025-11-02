import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../services/auth.service';

// Añadimos la ruta a la que se redirigirá cuando se inicie sesión
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent {

  username: string = '';
  password: string = '';

  public errorMessage: string | null = null;


  constructor(
    private authService: AuthService,
    // Añadimos la ruta
    private router: Router
  ) {}

  login(): void {
    
    const loginData = {
      nombre_usuario: this.username, 
      password: this.password
    };

    console.log('Enviando datos al backend:', loginData);

    this.errorMessage = null;
    
    this.authService.login(loginData).subscribe({
      next: (respuesta) => {
        
        console.log('Logueado con éxito', respuesta);

        // Guardamos el token en el localStorage del navegador
        localStorage.setItem('token', respuesta.token);
        console.log('Token recibido:', respuesta.token);
        

        // 1. Redirigimos al usuario a Inicio.
        this.router.navigate(['/']); 
        
        console.log('Pidiendo perfil del usuario');
        this.authService.getProfile().subscribe({
            
            next: (perfil) => {
                console.log('¡Perfil recibido!', perfil);
            },

            error: (errPerfil) => {
                // Si falla se verá en consola
                console.warn('getProfile() falló (404). El login fue OK, pero el perfil no se cargó.');
            }
          });
      },
      error: (error) => {
        // En caso de credenciales incorrectas
        console.error('¡No se ha podido iniciar sesión!', error);

        this.errorMessage = 'Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.';
      }
    });
  }
}