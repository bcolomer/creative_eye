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

  
  // productos: any[] = []; 

  // Renombramos la variable principal para guardar TODO el stock
  allProductos: any[] = []; 
  
  // Array que contiene solo los productos de la página actual
  paginatedProductos: any[] = []; 

  // Variables de configuración de paginación
  currentPage: number = 1;
  itemsPerPage: number = 6; // Muestra 6 productos por página
  totalPages: number = 0;

  
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
        this.allProductos = respuesta; 
        console.log('Productos recibidos:', this.allProductos.length);

        this.calculateTotalPages();
        this.updatePage();
      },

      
      error: (err) => {
        console.error('Error al pedir los productos a la base de datos:', err);
      }
    });
  }

calculateTotalPages(): void {
    this.totalPages = Math.ceil(this.allProductos.length / this.itemsPerPage);
  }

  updatePage(): void {
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    
    // "Cortamos" el array maestro para mostrar solo los de esta página
    this.paginatedProductos = this.allProductos.slice(startIndex, endIndex);
    
    // Scroll suave hacia arriba al cambiar
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  nextPage(): void {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
      this.updatePage();
    }
  }

  prevPage(): void {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.updatePage();
    }
  }

  goToPage(page: number): void {
    this.currentPage = page;
    this.updatePage();
  }
  
  // Helper para generar el array de números [1, 2, 3...] en el HTML
  get pagesArray(): number[] {
    return Array(this.totalPages).fill(0).map((x, i) => i + 1);
  }
}