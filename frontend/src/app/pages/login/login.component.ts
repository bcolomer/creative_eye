import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';

import { AuthService } from '../../services/auth.service';
import { CartService } from '../../services/cart.service';
import { ToastService } from '../../services/toast.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    RouterLink
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent {

  username: string = '';
  password: string = '';

  constructor(
    private authService: AuthService,
    private router: Router,
    private cartService: CartService,
    private toastService: ToastService
  ) {}

  login(): void {
    const loginData = {
      nombre_usuario: this.username, 
      password: this.password
    };

    this.authService.login(loginData).subscribe({
      next: (respuesta) => {
        
        this.toastService.show(`¡Bienvenido de nuevo, ${respuesta.user.nombre}!`, 'exito');

        // Cargamos el carrito
        this.cartService.loadCart().subscribe();

        // Redirigimos al inicio
        this.router.navigate(['/']); 
      },
      error: (error) => {
        console.error('Error login:', error);
        this.toastService.show('Usuario o contraseña incorrectos', 'error');
      }
    });
  }
}