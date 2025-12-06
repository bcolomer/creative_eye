import { Component, AfterViewInit, ViewChild, ElementRef } from '@angular/core'; 
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { ParallaxDirective } from '../../directives/parallax.directive';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [CommonModule, RouterLink, ParallaxDirective],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.scss'
})
export class InicioComponent implements AfterViewInit {
  @ViewChild('videoHero') videoHero!: ElementRef<HTMLVideoElement>;

  ngAfterViewInit(): void {
    if (this.videoHero && this.videoHero.nativeElement) {
      // Forzamos el mute para asegurar autoplay
      this.videoHero.nativeElement.muted = true;
      
      // Intentamos reproducir
      this.videoHero.nativeElement.play().catch(err => {
        console.warn('El navegador bloqueó el autoplay del video:', err);
      });
    }
  }
}
