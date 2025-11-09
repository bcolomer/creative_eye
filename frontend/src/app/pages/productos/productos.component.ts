import { Component, OnInit } from '@angular/core'; 
import { CommonModule } from '@angular/common'; 
import { RouterLink } from '@angular/router';


import { ProductService } from '../../services/product.service'; 

@Component({
  selector: 'app-productos',
  standalone: true,
  imports: [CommonModule, RouterLink], 
  templateUrl: './productos.component.html',
  styleUrl: './productos.component.scss'
})
export class ProductosComponent implements OnInit { 

  
  productos: any[] = []; 

  
  constructor(private productService: ProductService) {}

  /**
   * 8. ngOnInit() es una función especial de Angular
   * que se ejecuta automáticamente UNA VEZ, justo cuando
   * el componente está listo.
   */
  ngOnInit(): void {
    console.log('Buscando productos al servicio...');
    
    
    this.productService.getProducts().subscribe({
      
      
      next: (respuesta) => {
        // Guardamos los productos
        this.productos = respuesta; 
        console.log('Productos recibidos:', this.productos);
      },
      
      
      error: (err) => {
        console.error('Error al pedir los productos a la base de datos:', err);
      }
    });
  }

}