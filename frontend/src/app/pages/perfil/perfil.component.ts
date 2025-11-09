import { Component } from '@angular/core';

import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-perfil',
  standalone: true,
  imports: [],
  templateUrl: './perfil.component.html',
  styleUrl: './perfil.component.scss'
})


export class PerfilComponent {

  // Inyectamos el servicio de Auth para poder usarlo
  constructor(private authService: AuthService) {}

  // Crearemos la función para después llamarla con el botón de cerrar sesión
  logout(): void {
    this.authService.logout();
  }

}
