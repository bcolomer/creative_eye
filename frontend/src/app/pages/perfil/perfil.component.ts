import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth.service';
import { ToastService } from '../../services/toast.service'; 


@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './perfil.component.html',
  styleUrl: './perfil.component.scss'
})
export class PerfilComponent implements OnInit {

  usuario: any = {};

  // Campos de contraseña
  passActual: string = '';
  passNueva: string = '';
  passConfirm: string = '';

  // Archivo de foto
  selectedFile: File | null = null;
  nombreArchivo: string = 'Ningún archivo seleccionado'; 
  fotoUrl: any = 'assets/img/avatar-placeholder.png';

  // Variables visuales para los iconos (Ojo abierto/cerrado)
  mostrarPassActual: boolean = false;
  mostrarPassNueva: boolean = false;
  mostrarPassConfirm: boolean = false;

  constructor(
    public authService: AuthService,
    private toastService: ToastService 
  ) {}

  ngOnInit(): void {
    this.cargarDatosPerfil();
  }

  cargarDatosPerfil(): void {
    this.authService.getProfile().subscribe({
      next: (datos) => {
        this.usuario = datos;
        // Lógica para mostrar la foto actual del usuario
        if (this.usuario.foto) {
          if (this.usuario.foto.toString().startsWith('http')) {
            this.fotoUrl = this.usuario.foto;
          } else {
            this.authService.getProfileImage(this.usuario.foto).subscribe({
                next: (blob) => {
                  this.fotoUrl = URL.createObjectURL(blob);
                },
                error: () => {
                  this.fotoUrl = 'assets/img/avatar-placeholder.png';
                }
              });
          }
        }
      },
      error: (err) => {
        console.error(err);
        this.toastService.show('No se pudo cargar la información del perfil', 'error');
      }
    });
  }

  onFileSelected(event: any): void {
    const file: File = event.target.files[0];
    
    if (file) {
      this.selectedFile = file;
      this.nombreArchivo = file.name; 

      // Previsualización inmediata
      const reader = new FileReader();
      reader.onload = (e: any) => {
        this.fotoUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      this.nombreArchivo = 'Ningún archivo seleccionado';
    }
  }

actualizarPerfil(): void {
    // VALIDACIÓN: La contraseña actual es obligatoria
    if (!this.passActual) {
      this.toastService.show("Por seguridad, introduce tu contraseña actual", 'info');
      return;
    }

    // VALIDACIÓN DE NUEVA CONTRASEÑA (Si el usuario escribió algo en passNueva)
    if (this.passNueva) {
        // Validar longitud mínima
        if (this.passNueva.length < 8) {
            this.toastService.show('La nueva contraseña debe tener al menos 8 caracteres', 'error');
            return;
        }

        // Validar coincidencia
        if (this.passNueva !== this.passConfirm) {
            this.toastService.show('Las nuevas contraseñas no coinciden', 'error');
            return;
        }
    }

    const datosAEnviar: any = {
      nombre: this.usuario.nombre,
      current_password: this.passActual
    };

    if (this.passNueva) {
      datosAEnviar.password = this.passNueva;
      // Enviamos la confirmación también para que el Backend (Laravel) no se queje si usa 'confirmed' validation
      datosAEnviar.password_confirmation = this.passConfirm; 
    }

    this.authService.updateProfile(datosAEnviar, this.selectedFile || undefined).subscribe({
      next: (respuesta) => {
        this.toastService.show("Perfil actualizado correctamente", 'exito');

        this.passActual = '';
        this.passNueva = '';
        this.passConfirm = '';
        this.selectedFile = null;
        this.nombreArchivo = 'Ningún archivo seleccionado';
        
        this.cargarDatosPerfil();
      },
      error: (err) => {
        console.error('Error actualizando perfil:', err);
        
        
        if (err.status === 422) {
            this.toastService.show("Datos inválidos. Revisa la contraseña actual.", 'error');
        } else {
            this.toastService.show("No se pudo actualizar. Verifica tu contraseña actual.", 'error');
        }
      }
    });
  }

  logout(): void {
    this.authService.logout();
  }
}