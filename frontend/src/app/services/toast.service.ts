import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

export interface ToastData {
  mensaje: string;
  tipo: 'exito' | 'error' | 'info';
  mostrar: boolean;
}

@Injectable({
  providedIn: 'root'
})
export class ToastService {

  // Estado inicial: oculto
  private estadoInicial: ToastData = {
    mensaje: '',
    tipo: 'info',
    mostrar: false
  };

  // Observable que escucharán los componentes
  private toastSubject = new BehaviorSubject<ToastData>(this.estadoInicial);
  public toast$ = this.toastSubject.asObservable();

  private timer: any;

  constructor() { }

  /**
   * Muestra una notificación
   * @param mensaje Texto a mostrar
   * @param tipo 'exito' (verde), 'error' (rojo) o 'info' (azul/neutro)
   * @param duracion Tiempo en ms (por defecto 3000ms)
   */
  show(mensaje: string, tipo: 'exito' | 'error' | 'info' = 'info', duracion: number = 3000): void {
    
    // Si ya hay uno, limpiamos el timer anterior
    if (this.timer) {
      clearTimeout(this.timer);
    }

    // Emitimos el nuevo estado
    this.toastSubject.next({
      mensaje,
      tipo,
      mostrar: true
    });

    // Auto-ocultar después de X segundos
    this.timer = setTimeout(() => {
      this.close();
    }, duracion);
  }

  close(): void {
    this.toastSubject.next({ ...this.toastSubject.value, mostrar: false });
  }
}