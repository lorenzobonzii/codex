import { Component, Input, Output } from '@angular/core';
import { Subject } from 'rxjs';
import { FormField } from '../../models/form';
import { UpdateComponent } from '../update/update.component';
import { DeleteComponent } from '../delete/delete.component';

@Component({
  selector: 'app-actions',
  standalone: true,
  imports: [UpdateComponent, DeleteComponent],
  templateUrl: './actions.component.html',
  styleUrl: './actions.component.scss'
})
export class ActionsComponent {
  constructor() { }

  @Input()
  data: any = {};

  @Input()
  slug!: string;

  @Input()
  fields!: FormField[];

  ngOnInit(): void {
  }
}
