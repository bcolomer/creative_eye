
import { Injectable } from '@angular/core';

import { BehaviorSubject, Observable, tap, catchError, throwError } from 'rxjs';

import { HttpClient, HttpHeaders } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})


export class CartService {

  // URL de la api que llamará al backend
  private apiUrl = 'https://creative-eye-admin-panel.duckdns.org/api';

  // Es un 'BehaviorSubject' guarda una lista de productos (tipo any[]).
  private cartItems = new BehaviorSubject<any[]>([]); // Inicializamos con la lista vacía

  // El '$' al final ($) es una convención para nombrar Observables.
  public cartItems$ = this.cartItems.asObservable();

  constructor(private http: HttpClient) {

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
        this.cartItems.next(datos); // Actualizamos
      }),
      catchError((err) => {
        // Si la API falla (403, 404, 500...)
        console.error('Error al cargar el carrito:', err);
        // Publicamos un array vacío para que la app no se rompa
        this.cartItems.next([]); 
        // Re-lanzamos el error (opcional, pero buena práctica)
        return throwError(() => err); 
      })
    );
  }

addProduct(producto: any, cantidad: number): Observable<any> {

    // Recogemos la id del producto
    const idProducto = producto.producto_id;

    // Buscamos si el producto ya existe en nuestro carrito
    const itemsActuales = this.cartItems.value;

    // Buscamos coincidencia por producto_id
    const productoExistente = itemsActuales.find(item => item.producto_id === idProducto || item.id === idProducto);

    let cantidadFinal = cantidad;

    if (productoExistente) {
      cantidadFinal = productoExistente.cantidad + cantidad;
    }

    console.log(`Enviando el total a la base de datos`);

    const payload = {
      producto_id: idProducto, 
      cantidad: cantidadFinal  
    };

    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      })
    };

    // El backend actualizará el total existente
    const peticion = this.http.post(`${this.apiUrl}/order-products`, payload, httpOptions);

    return peticion.pipe(
      tap(respuesta => {
        console.log('Respuesta de añadir/actualizar producto:', respuesta);
        this.loadCart().subscribe();
      })
    );
  }


  // Limpiamos el carrito del usuario logeado para que el siguiente usuario no lo vea
  clearCart(): void {
    this.cartItems.next([]);
  }


  removeProduct(itemId: number): Observable<any> {
    
    console.log(`CartService: Eliminando item ${itemId} (DELETE /api/order-products/${itemId})...`);

    // Hacemos la petición DELETE a la API
    const peticion = this.http.delete(`${this.apiUrl}/order-products/${itemId}`);

    return peticion.pipe(
      tap(respuesta => {
        console.log('Respuesta de eliminar producto:', respuesta);
        // Recargamos el carrito
        this.loadCart().subscribe();
      })
    );
  }

  /**
   * Actualiza la cantidad de un producto en el carrito.
   * Backend: PUT /api/order-products/{id}
   */
  updateQuantity(itemId: number, quantity: number): Observable<any> {
    const payload = { cantidad: quantity };

    console.log(`CartService: Actualizando item ${itemId} a cantidad ${quantity}...`);

    return this.http.put(`${this.apiUrl}/order-products/${itemId}`, payload).pipe(
      tap(respuesta => {
        console.log('Cantidad actualizada:', respuesta);
        // Recargamos el carrito para que se recalcule el total y se vea reflejado
        this.loadCart().subscribe();
      }),
      catchError((err) => {
        console.error('Error al actualizar cantidad', err);
        return throwError(() => err);
      })
    );
  }

  /**
   * Devuelve el valor actual del carrito sin necesidad de suscribirse.
   */
  getCurrentCartItems(): any[] {
    return this.cartItems.value;
  }
}
