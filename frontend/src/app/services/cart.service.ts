
import { Injectable } from '@angular/core';

import { BehaviorSubject, Observable, tap } from 'rxjs';

import { HttpClient, HttpHeaders } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})


export class CartService {

  // URL de la api que llamará al backend
  private apiUrl = '/api';

  // Es un 'BehaviorSubject' guarda una lista de productos (tipo any[]).
  private cartItems = new BehaviorSubject<any[]>([]); // Inicializamos con la lista vacía

  // El '$' al final ($) es una convención para nombrar Observables.
  public cartItems$ = this.cartItems.asObservable();

  constructor(private http: HttpClient) {
    this.loadCart().subscribe();
  }

  
  //Cargar el carrito guardado (de la BBDD) Llama a la ruta de Cliente: GET /api/orders/my
  
  loadCart(): Observable<any> {
    console.log('Cargando carrito...');
    
    // 1. Llamamos a la API
    const peticion = this.http.get<any[]>(`${this.apiUrl}/order-products`);

    // 2. Usamos .pipe(tap(...)) para "espiar" la respuesta y actualizar nuestra memoria local
    return peticion.pipe(
      tap(datos => {
        console.log('Carrito cargado de la BBDD:', datos);
        this.cartItems.next(datos); // ¡Actualizamos la memoria!
      })
    );
  }

  addProduct(producto: any): Observable<any> {

    console.log('Enviando producto a la base de datos...', producto);

    const payload = {
      producto_id: producto.producto_id,
      cantidad: 1 // (Por ahora, añadimos de 1 en 1)
    };


    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };


    // Hacemos la petición POST
    const peticion = this.http.post(`${this.apiUrl}/order-products`, payload, httpOptions);

    // Actualizamos la memoria local con la respuesta que nos dé el backend (carrito actualizado).
    return peticion.pipe(
      tap(respuesta => {
        console.log('Respuesta de añadir producto:', respuesta);
        this.loadCart().subscribe();
      })
    );
  }
}
