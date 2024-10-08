/* eslint-disable @typescript-eslint/no-unsafe-argument */
import { Component, ElementRef, EventEmitter, Input, OnInit, Output, ViewChild } from '@angular/core';
import { fromEvent, take } from 'rxjs';
import { EventTypes } from '../../models/event-types';
import { CommonModule } from '@angular/common';
// @ts-ignore
import { Toast } from 'bootstrap';

@Component({
  selector: 'app-toast',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './toast.component.html',
  styleUrls: ['./toast.component.scss'],
})
export class ToastComponent implements OnInit {
  @Output() disposeEvent = new EventEmitter();

  @ViewChild('toastElement', { static: true })
  toastEl!: ElementRef;

  @Input()
  type!: EventTypes;

  @Input()
  title!: string;

  @Input()
  message!: string;

  @Input()
  note!: string;

  toast!: Toast;

  ngOnInit() {
    this.show();
  }

  show() {
    this.toast = new Toast(
      this.toastEl.nativeElement,
      {
        autohide: true,
        delay: 3000
      }
    );

    fromEvent(this.toastEl.nativeElement, 'hidden.bs.toast')
      .pipe(take(1))
      .subscribe(() => this.hide());

    this.toast.show();
  }

  hide() {
    this.toast.dispose();
    this.disposeEvent.emit();
  }

}
