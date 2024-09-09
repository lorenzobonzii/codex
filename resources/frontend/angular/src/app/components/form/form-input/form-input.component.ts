import { Component, Input } from '@angular/core';
import { FormField } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-form-input',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-input.component.html',
  styleUrl: './form-input.component.scss'
})
export class FormInputComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;

  showPassword = false;

  changeShowPassword() {
    this.showPassword = !this.showPassword;
  }

}
