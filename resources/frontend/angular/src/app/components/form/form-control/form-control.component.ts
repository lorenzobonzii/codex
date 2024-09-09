import { Component, Input } from '@angular/core';
import { FormField, SelectOption } from '../../../models/form';
import { AbstractControlOptions, FormArray, FormControl, FormGroup, FormRecord, ReactiveFormsModule, ValidatorFn, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { FormErrorComponent } from '../form-error/form-error.component';
import { FormInputComponent } from '../form-input/form-input.component';
import { FormSelectComponent } from '../form-select/form-select.component';
import { FormTextareaComponent } from '../form-textarea/form-textarea.component';
import { FormRadioComponent } from '../form-radio/form-radio.component';
import { FormImageComponent } from '../form-image/form-image.component';
import { FormCheckboxComponent } from '../form-checkbox/form-checkbox.component';

@Component({
  selector: 'app-form-control',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule, FormErrorComponent, FormInputComponent, FormSelectComponent, FormTextareaComponent, FormRadioComponent, FormImageComponent, FormCheckboxComponent],
  templateUrl: './form-control.component.html',
  styleUrl: './form-control.component.scss'
})
export class FormControlComponent {
  @Input()
  field!: FormField;

  @Input()
  optionsData!: SelectOption[][];

  @Input()
  group!: FormGroup;

  getFormGroupOfArray(array_name: string, index: number): FormGroup {
    var fa = this.group.get(array_name) as FormArray;
    var fg = fa.at(index) as FormGroup;
    return fg;
  }

  addGroupValue(e: Event) {
    e.preventDefault();
    var formFieldBase: FormField[] = JSON.parse(JSON.stringify(this.field.group?.fields));
    this.field.group?.values.push(formFieldBase);
    var fa = this.group.get(this.field.name) as FormArray;
    fa.push(this.createFormGroup(this.field.group?.fields));
  }

  deleteGroupValue(i: number, e: Event) {
    e.preventDefault();
    var fa = this.group.get(this.field.name) as FormArray;
    fa.removeAt(i);
    this.field.group?.values.splice(i, 1);
  }

  createFormGroup(fields?: FormField[], validators?: ValidatorFn[] | ValidatorFn | AbstractControlOptions): FormRecord {
    var fg = new FormRecord({}, validators);
    let that = this;
    if (fields) {
      fields.forEach(function (field) {
        if (field.type != "group") {
          fg.addControl(field.name, new FormControl(field.value, that.getFieldValidators2(field)));
        }
        else if (field.group?.values) {
          var fa = new FormArray([]);
          var array: FormRecord[] = [];
          field.group.values.forEach(function (value) {
            array.push(that.createFormGroup(value));
          })
          fg.addControl(field.name, new FormArray(array));
        }
      })
    }
    return fg;
  }

  getFieldValidators2(field: FormField): ValidatorFn[] {
    let controlValidators: ValidatorFn[] = [];
    if (field.validations) {
      field.validations.forEach(
        (validation: {
          name: string;
          validator: string;
          message: string;
          value?: any;
          placeholder?: string;
        }) => {
          if (validation.validator === 'required')
            controlValidators.push(Validators.required);
          if (validation.validator === 'pattern')
            controlValidators.push(Validators.pattern(validation.value));
          if (validation.validator === 'email')
            controlValidators.push(Validators.email);
          if (validation.validator === 'minLength')
            controlValidators.push(Validators.minLength(validation.value));
          if (validation.validator === 'maxLength')
            controlValidators.push(Validators.maxLength(validation.value));
          if (validation.validator === 'min')
            controlValidators.push(Validators.min(validation.value));
          if (validation.validator === 'max')
            controlValidators.push(Validators.max(validation.value));
          //if (validation.validator === 'confirmPassword' && validation.value)
          //  controlValidators.push(passwordConfirmation(this.dynamicFormGroup.get(validation.value).value));
        }
      );
    }
    return controlValidators;
  }
}
