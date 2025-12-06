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
  selectedFile: File | null = null;
  errorMessage: string | null = null;
  successMessage: string | null = null;
  fotoUrl: any = '/assets/images/creativelogo.png';

  // VARIABLES PARA VISIBILIDAD DE CONTRASEÑAS
  mostrarPassActual: boolean = false;
  mostrarPassNueva: boolean = false;
  mostrarPassConfirm: boolean = false;

  public nombreArchivo: string = 'Ningún archivo seleccionado';

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
        // ---PARA FOTO SEGURA ---
        if (this.usuario.foto) {
          // Si hay foto, la pedimos al servidor con el Token
          this.authService.getProfileImage(this.usuario.foto).subscribe({
            next: (blob) => {
              // Convertimos el archivo recibido en una URL que el navegador entienda
              this.fotoUrl = URL.createObjectURL(blob);
            },
            error: (e) => {
              console.error('No se pudo cargar la imagen protegida', e);
              this.fotoUrl = '/assets/images/creativelogo.png';
            }
          });
        }
        console.log('Datos cargados:', this.usuario);
      },
      error: (err) => {
        console.error('Error al cargar perfil:', err);
        this.errorMessage = 'No se pudieron cargar los datos del usuario.';
      }
    });
  }

  onFileSelected(event: any): void {
    const file: File = event.target.files[0];
    
    if (file) {
      this.selectedFile = file;
      this.nombreArchivo = file.name; 

      // Previsualización
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

/*     this.authService.updateProfile(datosAEnviar).subscribe({ */
      this.authService.updateProfile(datosAEnviar, this.selectedFile || undefined).subscribe({
      next: (respuesta) => {
        console.log('Perfil actualizado:', respuesta);

        // Esto fuerza al navegador a refrescarse, actualizando el Header y la foto al instante.
        window.location.reload();

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
  // Función para construir la URL de la imagen correctamente
  getFotoUrl(foto: string): string {
    //  Si no hay foto, mostramos el placeholder
    if (!foto) {
      return 'assets/img/avatar-placeholder.png';
    }

    //  Si la foto empieza por "data:", es la previsualización que acabas de subir
    // (Angular la muestra directamente)
    if (foto.toString().startsWith('data:')) {
      return foto;
    }

    //  Si la foto empieza por "http", es una URL externa (Google, etc.)
    if (foto.toString().startsWith('http')) {
      return foto;
    }

    //  Si es un nombre de archivo del backend, construimos la ruta a la API
    // Asegúrate de que el puerto 8000 coincide con tu Laravel
    return `http://127.0.0.1:8000/api/profile/photo/${foto}`;
  }
  // Crearemos la función para después llamarla con el botón de cerrar sesión
  logout(): void {
    this.authService.logout();
  }

}
