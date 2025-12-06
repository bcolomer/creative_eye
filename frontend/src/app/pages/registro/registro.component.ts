import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms'; // [(ngModel)]
import { Router, RouterLink } from '@angular/router'; 
import { AuthService } from '../../services/auth.service';
import { ToastService } from '../../services/toast.service';

@Component({
  selector: 'app-registro',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './registro.component.html',
  styleUrl: './registro.component.scss'
})
export class RegistroComponent {

  nombre: string = '';
  email: string = '';
  password: string = '';
  passwordConfirm: string = '';

  errorMessage: string | null = null;

  constructor(
    private authService: AuthService,
    private router: Router,
    private toastService: ToastService
  ) {}

  registro(): void {
    if (this.password !== this.passwordConfirm) {
      this.errorMessage = 'Las contraseñas no coinciden.';
      return;
    }

    const datosRegistro = {
      nombre: this.nombre,
      nombre_usuario: this.email,
      password: this.password
    };

    console.log('Enviando registro:', datosRegistro);
    this.errorMessage = null;

    this.authService.register(datosRegistro).subscribe({
      next: (respuesta) => {
        console.log('Registro con éxito:', respuesta);
        // alert('Cuenta creada con éxito. Por favor, inicia sesión.');
        this.toastService.show('¡Cuenta creada con éxito! Bienvenido a Creative Eye.', 'exito', 4000);
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error('Error en el registro:', err);
        this.errorMessage = 'Error al registrarse. Comprueba que el email no esté ya en uso.';
        this.toastService.show('Error en el registro', 'error');
      }
    });
  }
}