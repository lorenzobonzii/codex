import { Component, Input } from '@angular/core';
import { FormField } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-form-error',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-error.component.html',
  styleUrl: './form-error.component.scss'
})
export class FormErrorComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;

  getErrorMessage() {

    const formControl = this.group.get(this.field.name);

    if (!formControl) {
      return '';
    }
    if (this.field.validations)
      for (let validation of this.field.validations) {
        if (formControl.hasError(validation.name)) {
          return validation.message;
        }
      }
    if (formControl.hasError("confirmPasswordValidator")) {
      return "Le password devono coincidere"
    }
    if (formControl.errors?.["serverError"]) {

    }

    return '';
  }
}

