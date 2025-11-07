
import { Injectable } from '@angular/core';

import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})


export class CartService {

  // Es un 'BehaviorSubject' guarda
  // una lista de productos (tipo any[]).
  private cartItems = new BehaviorSubject<any[]>([]); // Inicializamos con la lista vacía

  // El '$' al final ($) es una convención para nombrar Observables.
  public cartItems$ = this.cartItems.asObservable();

  constructor() { }

  addProduct(producto: any): void {

    // Obtener la lista actual del carrito
    const currentItems = this.cartItems.getValue();
    
    const updatedItems = [...currentItems, producto];
    
    this.cartItems.next(updatedItems);
    
    console.log('Producto añadido al carrito:', producto);
    console.log('Carrito actual:', updatedItems);
  }
}
