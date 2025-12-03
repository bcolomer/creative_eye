import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';
import { CartService } from './services/cart.service';
import { AuthService } from './services/auth.service';
import { FooterComponent } from './shared/footer/footer.component';
import { DomSanitizer } from '@angular/platform-browser';

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
  public currentUser: any = null;

  // Imagen por defecto (Logo)
  public fotoUrl: any = 'assets/images/creativelogoheader.png';

  constructor(
    private cartService: CartService,
    public authService: AuthService,
    private sanitizer: DomSanitizer
  ) {}

  ngOnInit(): void {
    this.cartService.cartItems$.subscribe(items => {
      this.cartItemCount = items.length;
    });

    if (this.authService.isLoggedIn()) {
      this.cartService.loadCart().subscribe();
      this.cargarDatosUsuario();
    }
  }

cargarDatosUsuario(): void {
    this.authService.getProfile().subscribe({
      next: (datos) => {
        this.currentUser = datos;

        if (this.currentUser && this.currentUser.foto) {
          const foto = this.currentUser.foto;

          // CASO 1: URL externa (Jose)
          if (foto.toString().startsWith('http') || foto.toString().startsWith('data:')) {
             this.fotoUrl = foto;
          }
          // CASO 2: Archivo interno (Laura)
          else {
             this.authService.getProfileImage(foto).subscribe({
                next: (blob) => {
                   let objectURL = URL.createObjectURL(blob);
                   this.fotoUrl = this.sanitizer.bypassSecurityTrustUrl(objectURL);
                },
                error: (err) => {
                   console.error('Error cargando foto navbar:', err);
                   this.fotoUrl = 'assets/images/creativelogoheader.png';
                }
             });
          }
        }
      },
      error: (err) => console.log('Error al cargar usuario en navbar', err)
    });
  }

  toggleMenu(): void {
    this.menuAbierto = !this.menuAbierto;
  }

  closeMenu(): void {
    this.menuAbierto = false;
  }

  logout(): void {
      this.authService.logout();
  }
}
