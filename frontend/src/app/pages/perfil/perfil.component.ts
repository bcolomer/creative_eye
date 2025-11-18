import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './perfil.component.html',
  styleUrl: './perfil.component.scss'
})


export class PerfilComponent implements OnInit{

  usuario: any = {};

  passActual: string = '';
  passNueva: string = '';
  passConfirm: string = '';

  errorMessage: string | null = null;
  successMessage: string | null = null;

  // Inyectamos el servicio de Auth para poder usarlo
  constructor(private authService: AuthService) {}

  ngOnInit(): void {
    this.cargarDatosPerfil();
  }

  cargarDatosPerfil(): void {
    console.log('Cargando datos del perfil...');
    this.authService.getProfile().subscribe({
      next: (datos) => {
        this.usuario = datos;
        console.log('Datos cargados:', this.usuario);
      },
      error: (err) => {
        console.error('Error al cargar perfil:', err);
        this.errorMessage = 'No se pudieron cargar los datos del usuario.';
      }
    });
  }


  actualizarPerfil(): void {

    // SI LA CONTRASEÑA NO COINCIDE CON LA ACTUAL
    if (!this.passActual) {
      const mensajeError = "No se realizaron cambios porque no se ha podido validar su contraseña actual";
      console.log(mensajeError);
      alert(mensajeError);
      return;
    }

    // Validación de contraseñas nuevas
    if (this.passNueva && (this.passNueva !== this.passConfirm)) {
      this.errorMessage = 'Las nuevas contraseñas no coinciden.';
      return;
    }

    const datosAEnviar: any = {
      nombre: this.usuario.nombre,
      // Backend comprueba y verifica contraseña
      current_password: this.passActual 
    };

    // Si quiere cambiar la contraseña, añadimos la nueva
    if (this.passNueva) {
      datosAEnviar.password = this.passNueva;
    }

    console.log('Enviando actualización con validación:', datosAEnviar);

    this.authService.updateProfile(datosAEnviar).subscribe({
      next: (respuesta) => {
        console.log('Perfil actualizado:', respuesta);

        alert("Perfil cambiado correctamente");
        // this.successMessage = 'Datos actualizados correctamente.';
        
        // Limpiamos los campos de contraseña
        this.passActual = '';
        this.passNueva = '';
        this.passConfirm = '';

        this.cargarDatosPerfil();

      },
      error: (err) => {
        console.error('Error actualizando perfil:', err);
        // this.errorMessage = 'No se pudieron guardar los cambios. Verifica que tu contraseña actual sea correcta.';
        alert("Error: La contraseña actual introducida no es correcta.");
      }
    });
  }

  // Crearemos la función para después llamarla con el botón de cerrar sesión
  logout(): void {
    this.authService.logout();
  }

}
