import { Injectable } from '@angular/core';

// iMPORTAMOS el HttpClient y Observable
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  private apiUrl = environment.apiUrl;
  // private apiUrl = '/api'; 

  // HttpClient para poder hacer peticiones
  constructor(private http: HttpClient) { }

  getProducts(): Observable<any> {

    return this.http.get(`${this.apiUrl}/products`);
  }


  getProductById(id: string): Observable<any> {

    return this.http.get(`${this.apiUrl}/products/${id}`);
    
  }


  
}