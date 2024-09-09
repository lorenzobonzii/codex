import { Component, EventEmitter, Input, OnInit, Output } from "@angular/core";
import { AbstractControlOptions, Form, FormArray, FormBuilder, FormControl, FormGroup, FormRecord, FormsModule, ReactiveFormsModule, ValidatorFn, Validators } from "@angular/forms";
import { FormField, SelectOption } from "../../models/form";
import { CommonModule } from "@angular/common";
import { confirmPasswordValidator } from "./password-confirmation.directive";
import { ServerErrorService } from "../../services/serverError/serverError.service";
import { FormInputComponent } from "./form-input/form-input.component";
import { FormControlComponent } from "./form-control/form-control.component";
import { Subscription } from "rxjs";

@Component({
  selector: 'app-form',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule, FormInputComponent, FormControlComponent],
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss'
})
export class FormComponent implements OnInit {
  @Input() fields!: FormField[];
  @Input() optionsData!: SelectOption[][];
  dynamicFormGroup: FormGroup = this.fb.group({});
  @Output() onFormGroupChange: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();
  subscriptions: Subscription[] = [];

  constructor(private serverErrorService: ServerErrorService, private fb: FormBuilder) {

  }

  ngOnInit(): void {
    this.dynamicFormGroup = this.createFormGroup(this.fields);
  }

  getFieldValidators2(field: FormField, fg: FormGroup): ValidatorFn[] {
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
          if (validation.validator === 'confirmPassword' && validation.value)
            controlValidators.push(confirmPasswordValidator(fg.controls[validation.value]));
        }
      );
    }
    return controlValidators;
  }

  createFormGroup(fields?: FormField[], validators?: ValidatorFn[] | ValidatorFn | AbstractControlOptions): FormRecord {
    var fg = new FormRecord({}, validators);
    let that = this;
    if (fields) {
      fields.forEach(function (field) {
        if (field.type != "group" && field.type != "checkbox") {
          fg.addControl(field.name, new FormControl(field.value, that.getFieldValidators2(field, fg)));
        }
        else if (field.type == "checkbox" && field.optionData) {
          var fa = new FormArray([]);
          var array: FormRecord[] = [];
          fg.addControl(field.name, that.fb.array(that.optionsData[field.optionData.slug].map(x => {
            if (field.values?.includes(Number.parseInt(x.value.toString())))
              return x.value;
            else
              return false;
          })));
          const checkboxControl = (fg.controls[field.name] as FormArray);
          that.subscriptions.push(
            checkboxControl.valueChanges.subscribe(checkbox => {
              checkboxControl.setValue(
                checkboxControl.value.map((value: any, i: number) => value ? that.optionsData[field.optionData?.slug][i].value : false),
                { emitEvent: false }
              );
            })
          );
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

  changePassword(control: any) {
    this.fields?.forEach((field) => {
      if (field.name == control.name) {
        field.showPassword = !field.showPassword;
      }
    });
  }

  onSubmit() {
    if (!this.dynamicFormGroup.valid) {
      this.dynamicFormGroup.markAllAsTouched();
      return;
    }
    else {
      this.serverErrorService.clear();
      this.onFormGroupChange.emit(this.dynamicFormGroup);
    }
  }

}

