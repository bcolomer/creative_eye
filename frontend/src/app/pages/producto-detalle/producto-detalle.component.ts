import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { ProductService } from '../../services/product.service';
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

  producto: any = null;
  errorMessage: string | null = null;
  
  // Cantidad que el usuario quiere añadir AHORA
  public cantidad: number = 1; 
  
  // Cantidad que el usuario YA TIENE en el carrito de este producto
  public cantidadEnCarrito: number = 0; 

  private audioObturador = new Audio('/assets/sounds/sonido-obturador.mp3');
  
  // --- GRÁFICA ---
  public mostrarGrafica: boolean = false;
  public radarChartOptions: ChartOptions<'radar'> = {
    responsive: true,
    maintainAspectRatio: false,
    elements: { line: { borderWidth: 3 } },
    scales: {
      r: {
        angleLines: { color: 'rgba(0,0,0,0.1)' },
        grid: { color: 'rgba(0,0,0,0.1)' },
        pointLabels: { font: { size: 12, family: 'Poppins' }, color: '#202022' },
        ticks: { display: false, stepSize: 20 }
      }
    }
  };
  public radarChartLabels: string[] = ['Foto', 'Batería', 'Versatilidad', 'Construcción', 'Vídeo'];
  public radarChartDatasets: ChartConfiguration<'radar'>['data']['datasets'] = [
    { data: [0, 0, 0, 0, 0], label: 'Análisis Técnico' }
  ];

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private productService: ProductService,
    private cartService: CartService, 
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    const productoId = this.route.snapshot.paramMap.get('id');
    
    // 1. Pedimos el producto
    if (productoId) {
      this.productService.getProductById(productoId).subscribe({
        next: (respuesta) => {
          this.producto = respuesta;
          
          if (this.producto.categoria_id === 1 || this.producto.categoria_id === 2) {
            this.mostrarGrafica = true;
            this.generarGrafica();
          }
          
          // Calculamos stock inicial una vez cargado el producto
          this.calcularHuecoEnCarrito(this.cartService.getCurrentCartItems());
        },
        error: (err) => this.errorMessage = 'Producto no encontrado'
      });
    }

    // 2. Nos suscribimos al carrito (por si cambia mientras estamos viendo el producto)
    this.cartService.cartItems$.subscribe(items => {
      this.calcularHuecoEnCarrito(items);
    });
  }

  // Función auxiliar para calcular cuánto tenemos ya
  calcularHuecoEnCarrito(items: any[]): void {
    if (!this.producto || !items) return;

    // Buscamos si el producto actual (this.producto.producto_id) está en el array de items
    const coincidencia = items.find(item => item.producto.producto_id === this.producto.producto_id);

    // Si existe, guardamos la cantidad. Si no, es 0.
    this.cantidadEnCarrito = coincidencia ? coincidencia.cantidad : 0;
    
    console.log(`Stock Total: ${this.producto.cantidad} | En Carrito: ${this.cantidadEnCarrito}`);
  }

  // Busca este producto en el carrito y guarda cuántos tenemos
  verificarStockEnCarrito(): void {
    if (!this.producto) return;

    // Obtenemos el valor actual del carrito (si tu servicio expone el BehaviorSubject o mediante la suscripción anterior)
    // Como estamos dentro de un subscribe o ngOnInit, asumimos que cartService tiene los datos cargados.
    // Nota: Para acceder al valor actual sin suscribirse de nuevo, podemos usar un truco si el servicio no expone getValue(),
    // pero lo ideal es usar la suscripción de ngOnInit.
  }

  generarGrafica(): void {
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
    
    // 1. Bloqueo Mínimo
    if (nuevaCantidad < 1) return;

    // 2. Bloqueo Máximo (Stock Real - Lo que ya tengo en el carrito)
    const stockDisponibleReal = this.producto.cantidad - this.cantidadEnCarrito;

    if (nuevaCantidad > stockDisponibleReal) {
      // Opcional: alert(`Solo quedan ${stockDisponibleReal} unidades disponibles.`);
      return;
    }
    
    this.cantidad = nuevaCantidad;
  }

  addToCart(): void { 
    if (!this.authService.isLoggedIn()) {
      alert('Debes iniciar sesión para comprar.');
      this.router.navigate(['/login']);
      return; 
    }

    // Validación final antes de enviar
    const stockDisponibleReal = this.producto.cantidad - this.cantidadEnCarrito;
    
    if (this.cantidad > stockDisponibleReal) {
      alert('No hay suficiente stock para añadir esa cantidad.');
      return;
    }

    if (this.producto) {
      this.cartService.addProduct(this.producto, this.cantidad).subscribe({
        next: () => {
          this.audioObturador.play().catch(e => console.warn(e));
          alert('¡Producto añadido al carrito!'); 
          this.cantidad = 1; // Reseteamos el selector a 1
        },
        error: (err) => {
          console.error(err);
          alert('Error al añadir el producto.');
        }
      });
    }
  }
}