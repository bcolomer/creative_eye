import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; // Para usar *ngIf en el HTM


import { ActivatedRoute, Router } from '@angular/router'; // Lee la URL
import { AuthService } from '../../services/auth.service';
import { ProductService } from '../../services/product.service'; // Para PEDIR el producto
import { CartService } from '../../services/cart.service';

import { BaseChartDirective } from 'ng2-charts';
import { ChartConfiguration, ChartOptions } from 'chart.js';

@Component({
  selector: 'app-producto-detalle',
  standalone: true,
  imports: [CommonModule, BaseChartDirective],
  templateUrl: './producto-detalle.component.html',
  styleUrl: './producto-detalle.component.scss'
})

export class ProductoDetalleComponent implements OnInit {

  //Variable que guardará el producto
  producto: any = null;

  // Controlar en caso de no encontrar un producto 
  errorMessage: string | null = null; // Para guardar el mensaje de error
  public cantidad: number = 1;

  private audioObturador = new Audio('/assets/sounds/sonido-obturador.mp3');

  public mostrarGrafica: boolean = false;

  // --- CONFIGURACIÓN GRÁFICA RADAR ---
  public radarChartOptions: ChartOptions<'radar'> = {
    responsive: true,
    maintainAspectRatio: false,
    elements: { line: { borderWidth: 3 } },
    scales: {
      r: {
        angleLines: { color: 'rgba(0,0,0,0.1)' },
        grid: { color: 'rgba(0,0,0,0.1)' },
        pointLabels: {
          font: { size: 12, family: 'Poppins' },
          color: '#202022'
        },
        ticks: { display: false, stepSize: 20 }
      }
    }
  };

  public radarChartLabels: string[] = ['Foto', 'Batería', 'Versatilidad', 'Construcción', 'Vídeo'];

  public radarChartDatasets: ChartConfiguration<'radar'>['data']['datasets'] = [
    { data: [0, 0, 0, 0, 0], label: 'Análisis Técnico' } // Se rellenará luego
  ];

  constructor(
    private route: ActivatedRoute, // Para leer la URL
    private router: Router,
    private productService: ProductService, // Para pedir datos
    private cartService: CartService,
    private authService: AuthService
  ) {}

  ngOnInit(): void {

    const productoId = this.route.snapshot.paramMap.get('id');
    
    // Comprobamos que el ID no esté vacío
    if (productoId) {
      console.log('Pidiendo producto... producto con ID:', productoId);
      this.productService.getProductById(productoId).subscribe({
        
        next: (respuesta) => {
          // Producto encontrado
          this.producto = respuesta;
          if (this.producto.categoria_id === 1 || this.producto.categoria_id === 2) {
            this.mostrarGrafica = true;
            this.generarGrafica(); // Solo generamos datos si es cámara
          } else {
            this.mostrarGrafica = false;
          }
          console.log('Producto recibido:', this.producto);
        },
        error: (err) => {
          console.error('Error al pedir el producto:', err);
          // Cuando no encontramos el producto porque no existe o pedimos alguno que no está en la bbdd
          this.errorMessage = 'El producto no existe o no se ha podido cargar.';
        }
      });
    }
  }

  generarGrafica(): void {
    // Generamos números aleatorios entre 60 y 100
    const datos = Array.from({length: 5}, () => Math.floor(Math.random() * 40) + 60);
    
    this.radarChartDatasets = [{
      data: datos,
      label: `Análisis: ${this.producto.nombre}`,
      borderColor: '#00747C', 
      backgroundColor: 'rgba(0, 187, 201, 0.2)', 
      pointBackgroundColor: '#00747C',
      pointBorderColor: '#fff'
    }];
  }

  actualizarCantidad(valor: number): void {
    const nuevaCantidad = this.cantidad + valor;
    
    if (nuevaCantidad >= 1) {
      this.cantidad = nuevaCantidad;
    }
  }

  // Llamamos al CartService para añadir el producto actual al carrito.
  addToCart(): void { 
    
    // Comprobamos si NO está logueado
    if (!this.authService.isLoggedIn()) {
      alert('Debes ser un usuario registrado para realizar la compra');
      this.router.navigate(['/login']);
      return; 
    }

    // Si está logueado, continúa normal
    if (this.producto) {
      this.cartService.addProduct(this.producto, this.cantidad).subscribe({
        next: (respuesta) => {
          this.audioObturador.play().catch(error => console.warn('No se pudo reproducir el sonido:', error));
          alert('¡Producto añadido al carrito!'); 
          this.cantidad = 1; 
        },
        error: (err) => {
          console.error(err);
          alert('No se pudo añadir el producto. Inténtalo de nuevo.');
        }
      });
    }
  }
}