import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ToastService, ToastData } from '../../services/toast.service';

@Component({
  selector: 'app-toast',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './toast.component.html',
  styleUrl: './toast.component.scss'
})
export class ToastComponent implements OnInit {

  datos: ToastData = { mensaje: '', tipo: 'info', mostrar: false };

  constructor(public toastService: ToastService) {}

  ngOnInit(): void {
    this.toastService.toast$.subscribe(data => {
      this.datos = data;
    });
  }

  cerrar(): void {
    this.toastService.close();
  }
}