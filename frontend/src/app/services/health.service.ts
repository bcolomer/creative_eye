import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HealthService {

  constructor(private http: HttpClient) {}
  ping() {
    // return this.http.get<{ ok: boolean; laravel: string; time: string }>('/api/health');
    return this.http.get<{ ok: boolean; laravel: string; time: string }>(`${environment.apiUrl}/health`);
  }
}
