import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class HealthService {

  constructor(private http: HttpClient) {}
  ping() {
    return this.http.get<{ ok: boolean; laravel: string; time: string }>('/api/health');
  }
}
