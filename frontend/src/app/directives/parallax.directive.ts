import { Directive, ElementRef, HostListener, Input, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appParallax]',
  standalone: true
})
export class ParallaxDirective {

  // Factor de velocidad (0.5 = se mueve a la mitad de velocidad que el scroll)
  @Input('ratio') ratio: number = 0.5;

  constructor(private el: ElementRef, private renderer: Renderer2) { }

  @HostListener('window:scroll', ['$event'])
  onWindowScroll() {
    const scrollPosition = window.scrollY;
    
    // Calculamos el desplazamiento
    const valor = scrollPosition * this.ratio;
    
    // Aplicamos la transformación CSS directamente
    this.renderer.setStyle(
      this.el.nativeElement,
      'transform',
      `translateY(${valor}px)`
    );
  }
}