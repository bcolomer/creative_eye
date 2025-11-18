import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; 

import { Observable } from 'rxjs'; 
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
    
    this.cartService.cartItems$.subscribe({
      
      next: (productos) => {
        this.productosDelCarrito = productos;
        console.log('Actualización de productos', this.productosDelCarrito);

        this.calcularTotal();
      },
      error: (err) => {
        console.error('Error al hacer click en el carrito:', err);
      }
    });

    this.cartService.loadCart().subscribe();
  }

  calcularTotal(): void {
    this.totalCarrito = this.productosDelCarrito.reduce(
      (acumulador, item) => acumulador + parseFloat(item.precio_total), 
      0 
    );
  }

  eliminarProducto(itemId: number): void {
    
    console.log('Solicitando eliminar el item ID:', itemId);
    
    // Llamamos a la función del servicio
    this.cartService.removeProduct(itemId).subscribe({
      
      next: (respuesta) => {
        console.log('Producto eliminado con éxito', respuesta);
      },
      error: (err) => {
        console.error('Error al eliminar el producto:', err);
        alert('No se pudo eliminar el producto.');
      }
    });
  }
}