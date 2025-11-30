import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { CartService } from './services/cart.service';
// import { HealthService } from './services/health.service';
// import { LoginComponent } from './pages/login/login.component';
import { AuthService } from './services/auth.service';

// LoginComponent - Prueba
@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet, RouterLink, RouterLinkActive],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit { 
  title = 'frontend';

  public cartItemCount: number = 0;

  constructor(
    private cartService: CartService,
    private authService: AuthService
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
}
