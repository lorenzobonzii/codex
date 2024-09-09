import { Component, Input } from '@angular/core';
import { FormField, SelectOption } from '../../../models/form';
import { FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-form-select',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './form-select.component.html',
  styleUrl: './form-select.component.scss'
})
export class FormSelectComponent {
  @Input()
  field!: FormField;

  @Input()
  group!: FormGroup;

  @Input()
  optionsData!: SelectOption[][];


  options: SelectOption[] = [];

  ngOnInit() {
    if (this.optionsData && this.field.optionData && this.field.optionData.slug && this.field.optionData.slug in this.optionsData) {
      this.options = this.optionsData[this.field.optionData.slug];
    }
    else if (this.field.options)
      this.options = this.field.options;
  }
}
