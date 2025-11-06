import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; // Para usar *ngIf en el HTM


import { ActivatedRoute } from '@angular/router'; // Lee la URL
import { ProductService } from '../../services/product.service'; // Para PEDIR el producto


@Component({
  selector: 'app-producto-detalle',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './producto-detalle.component.html',
  styleUrl: './producto-detalle.component.scss'
})

export class ProductoDetalleComponent implements OnInit {

  //Variable que guardará el producto
  producto: any = null;

  // *** Controlar en caso de no encontrar un producto ****
  errorMessage: string | null = null; // Para guardar el mensaje de error


  constructor(
    private route: ActivatedRoute, // Para leer la URL
    private productService: ProductService // Para pedir datos
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

}