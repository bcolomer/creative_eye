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
  }

  calcularTotal(): void {
    this.totalCarrito = this.productosDelCarrito.reduce((acumulador, item) => acumulador + parseFloat(item.precio), 0 );
  }
}