import { Component, Input } from '@angular/core';
import { FormField, SelectOption } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-form-checkbox',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-checkbox.component.html',
  styleUrl: './form-checkbox.component.scss'
})
export class FormCheckboxComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;

  @Input()
  optionsData!: SelectOption[][];
  checkboxes: any[] = [];
  options: SelectOption[] = [];

  ngOnInit() {
    if (this.optionsData && this.field.optionData && this.field.optionData.slug && this.field.optionData.slug in this.optionsData) {
      this.options = this.optionsData[this.field.optionData.slug];
    }
    else if (this.field.options)
      this.options = this.field.options;
  }
}
