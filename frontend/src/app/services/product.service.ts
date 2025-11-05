import { Injectable } from '@angular/core';

// iMPORTAMOS el HttpClient y Observable
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  
  private apiUrl = '/api'; 

  // HttpClient para poder hacer peticiones
  constructor(private http: HttpClient) { }

  getProducts(): Observable<any> {

    return this.http.get(`${this.apiUrl}/products`);
  }


  
}