import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; 
import { CartService } from '../../services/cart.service'; 

@Component({
  selector: 'app-carrito',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './carrito.component.html',
  styleUrl: './carrito.component.scss'
})
export class CarritoComponent implements OnInit {

  public productosDelCarrito: any[] = [];
  public totalCarrito: number = 0;

  constructor(private cartService: CartService) {}

  ngOnInit(): void {
    // Nos suscribimos a los cambios del carrito
    this.cartService.cartItems$.subscribe({
      next: (productos) => {
        this.productosDelCarrito = productos;
        this.calcularTotal();
      },
      error: (err) => console.error('Error suscripción carrito:', err)
    });

    // Cargamos la primera vez
    this.cartService.loadCart().subscribe();
  }

  calcularTotal(): void {
    // Parseamos a float para asegurar operaciones matemáticas correctas
    this.totalCarrito = this.productosDelCarrito.reduce(
      (acumulador, item) => acumulador + parseFloat(item.precio_total), 
      0 
    );
  }

  /**
   * Gestiona el aumento o disminución de cantidad
   * @param item El producto del carrito (OrderProduct)
   * @param cambio +1 o -1
   */
  actualizarCantidad(item: any, cambio: number): void {
    const nuevaCantidad = item.cantidad + cambio;

    // 1. BLOQUEO AL BAJAR (MÍNIMO 1)
    if (nuevaCantidad < 1) {
      return; 
    }

    // 2. CONTROL DE STOCK AL AUMENTAR
    if (cambio > 0 && item.cantidad >= item.producto.cantidad) {
      alert(`¡Lo sentimos! Solo quedan ${item.producto.cantidad} unidades disponibles.`);
      return; 
    }

    // 3. LLAMADA A LA API
    this.cartService.updateQuantity(item.id, nuevaCantidad).subscribe({
      error: (err) => {
        console.error('Error al actualizar cantidad:', err);
      }
    });
  }

  eliminarProducto(itemId: number): void {
    if(!confirm('¿Seguro que quieres eliminar este producto?')) return;

    this.cartService.removeProduct(itemId).subscribe({
      error: (err) => {
        console.error('Error al eliminar:', err);
        alert('No se pudo eliminar el producto.');
      }
    });
  }
}