import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../services/auth.service';

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

  
  constructor(private authService: AuthService) {}

  login(): void {
    
    const loginData = {
      nombre_usuario: this.username, 
      password: this.password
    };

    console.log('Enviando datos al backend:', loginData);

    
    this.authService.login(loginData).subscribe({
      next: (respuesta) => {
        
        console.log('Logueado con éxito', respuesta);

        // Guardamos la "llave" (el token) en el localStorage del navegador
        localStorage.setItem('token', respuesta.token);

        console.log('Token recibido:', respuesta.token);
        
      },
      error: (error) => {
        
        console.error('¡No se ha podido iniciar sesión!', error);
      }
    });
  }
}