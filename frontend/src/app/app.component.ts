import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet } from '@angular/router';
// import { HealthService } from './services/health.service';
// import { LoginComponent } from './pages/login/login.component';

// LoginComponent - Prueba
@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet, ],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'frontend';
  msg = '';

  // constructor(private health: HealthService) {}

  // checkApi() {
  //   this.health.ping().subscribe({
  //     next: (res) => (this.msg = `✅ API ok: Laravel ${res.laravel} (${res.time})`),
  //     error: (err) => (this.msg = `❌ Error: ${err.message}`)
  //   });
  // }
}
