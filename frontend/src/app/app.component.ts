import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { CartService } from './services/cart.service';
// import { HealthService } from './services/health.service';
// import { LoginComponent } from './pages/login/login.component';
import { AuthService } from './services/auth.service';
import { FooterComponent } from './shared/footer/footer.component';

// LoginComponent - Prueba
@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet, RouterLink, RouterLinkActive, FooterComponent],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit { 
  title = 'frontend';

  public cartItemCount: number = 0;

  public menuAbierto: boolean = false;

  constructor(
    private cartService: CartService,
    // private authService: AuthService
    public authService: AuthService
  ) {}

  ngOnInit(): void {

    this.cartService.cartItems$.subscribe(items => {

      this.cartItemCount = items.length;
      console.log('Cambios en carrito:', this.cartItemCount);
    });

    if (this.authService.isLoggedIn()) {
      console.log('Usuario ya logueado, cargando carrito...');
      this.cartService.loadCart().subscribe();
    }
  }

  // Método para cambiar el estado del menú
  toggleMenu(): void {
    this.menuAbierto = !this.menuAbierto;
  }

  // Método para cerrar el menú cuando pulsas en un enlace
  closeMenu(): void {
    this.menuAbierto = false;
  }
}
