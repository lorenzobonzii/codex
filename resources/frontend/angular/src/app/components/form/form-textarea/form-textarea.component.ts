import { Component, Input } from '@angular/core';
import { FormField } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-form-textarea',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-textarea.component.html',
  styleUrl: './form-textarea.component.scss'
})
export class FormTextareaComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;
}
