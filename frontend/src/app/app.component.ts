import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { CartService } from './services/cart.service';
import { AuthService } from './services/auth.service';
import { FooterComponent } from './shared/footer/footer.component';
import { DomSanitizer } from '@angular/platform-browser';
import { ToastComponent } from './shared/toast/toast.component';
import { environment } from '../environments/environment';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet, RouterLink, RouterLinkActive, FooterComponent, ToastComponent],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'frontend';
  public cartItemCount: number = 0;
  public menuAbierto: boolean = false;
  public currentUser: any = null;
  public fotoUrl: any = '/assets/images/creativelogo.png';

  public backendUrl = environment.backendUrl;
  constructor(
    public cartService: CartService, 
    public authService: AuthService, 
    private sanitizer: DomSanitizer
  ) {}

  ngOnInit(): void {
    // Suscripción reactiva al Carrito
    this.cartService.cartItems$.subscribe(items => {
      this.cartItemCount = items.length;
    });

    // Suscripción reactiva al Usuario (Header se actualiza solo)
    this.authService.user$.subscribe(user => {
        this.currentUser = user;
        
        if (user) {
            this.procesarFotoUsuario(user.foto);
        } else {
            this.fotoUrl = '/assets/images/creativelogo.png';
        }
    });

    // CARGA INICIAL 
    if (this.authService.isLoggedIn()) {
      // Forzamos la carga del perfil y del carrito al iniciar la app
      this.authService.getProfile().subscribe({
        error: () => {
            // Si el token caducó o es inválido, cerramos sesión
            this.authService.logout();
        }
      });
      this.cartService.loadCart().subscribe();
    }
  }

  procesarFotoUsuario(foto: string | null): void {
      if (!foto) {
          this.fotoUrl = '/assets/images/creativelogo.png';
          return;
      }

      // Si es URL externa o base64 (previsualización)
      if (foto.toString().startsWith('http') || foto.toString().startsWith('data:')) {
          this.fotoUrl = foto;
      } 
      // Si es archivo interno de Laravel (protegido)
      else {
          this.authService.getProfileImage(foto).subscribe({
            next: (blob) => {
                let objectURL = URL.createObjectURL(blob);
                this.fotoUrl = this.sanitizer.bypassSecurityTrustUrl(objectURL);
            },
            error: () => {
                this.fotoUrl = '/assets/images/creativelogo.png';
            }
          });
      }
  }

  toggleMenu(): void { this.menuAbierto = !this.menuAbierto; }
  closeMenu(): void { this.menuAbierto = false; }
  logout(): void { this.authService.logout(); }
}