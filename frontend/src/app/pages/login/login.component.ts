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

        // Guardamos la "llave" (el token) en el localStorage del navegador
        localStorage.setItem('token', respuesta.token);
        console.log('Token recibido:', respuesta.token);
        

        // Pedimos el perfil del usuario
        console.log('Pidiendo perfil del usuario...');
        this.authService.getProfile().subscribe({
            next: (perfil) => {
                // Si funciona mostrará
                console.log('¡Perfil recibido!', perfil);

                // Esto redirige al home
                this.router.navigate(['/']);
              },

            error: (errPerfil) => {
                // Si el interceptor falla o el token es inválido
                console.error('Error pidiendo el perfil:', errPerfil);
              }
          });
      },
      error: (error) => {
        console.error('¡No se ha podido iniciar sesión!', error);

        this.errorMessage = 'Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.';
      }
    });
  }
}