import { Component, Input, NgModule, TemplateRef } from '@angular/core';
import { ApiService } from '../../services/api/api.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { FormComponent } from '../form/form.component';
import { Form, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth/auth.service';
import { ToastService } from '../../services/toast/toast.service';
import { ActivatedRoute, OnSameUrlNavigation, Router, RouterModule } from '@angular/router';
import { FormField, SelectOption } from '../../models/form';
import { data } from 'jquery';
import { group } from '@angular/animations';
import { combineLatest, firstValueFrom, last } from 'rxjs';
import { Option } from '../../models/option';
import { NgxSpinnerComponent, NgxSpinnerService } from "ngx-spinner";
import { routes } from '../../app.routes';
@Component({
  selector: 'app-update',
  standalone: true,
  imports: [FormComponent, ReactiveFormsModule, FormsModule, NgxSpinnerComponent, RouterModule],
  templateUrl: './update.component.html',
  styleUrl: './update.component.scss'
})
export class UpdateComponent {
  constructor(private authService: AuthService, private toastService: ToastService, private apiService: ApiService, private router: Router, private route: ActivatedRoute, private modalService: NgbModal, private spinner: NgxSpinnerService) { }

  submitted = false;
  @Input() slug!: string;
  @Input() data!: any;
  @Input() fields!: FormField[];
  path!: any;
  modal_update!: any;
  isLoading: boolean = false;
  models_slug: FormField["optionData"][] = [];
  optionsData: SelectOption[][] = [];

  modalOptions: any = {
    ariaLabelledBy: 'modal-basic-title',
    centered: true,
    size: 'lg'
  };
  async open(content: TemplateRef<any>) {
    this.spinner.show();
    let this2 = this;
    this.path = this.route.routeConfig?.path?.split('/');
    if (this.path.slice(-1)[0].toString().includes(':')) {
      this.path.pop();
    }
    this.fields.forEach(function (field) {
      if (field.validations) {
        field.validations.forEach(function (validation) {
          if (validation.name == "required") {
            validation.name = "";
            validation.validator = "";
            validation.message = "";
          }
        })
      }
    });
    if (this.fields) {
      this.setModelsData(this.fields);
      if (this.models_slug.length > 0) {
        const observables = this.models_slug.map((slug: FormField["optionData"]) => (
          this2.apiService.get(slug?.slug)
        ));
        combineLatest(observables).subscribe((values) => {
          values.forEach(function (results, index) {
            let slug = this2.models_slug[index];
            this2.optionsData[slug?.slug] = results.data.map((x: any) => ({ label: x[slug?.slug_label!], value: x[slug?.slug_value!] }));
          });
          this2.fields = this2.setValues(this2.fields, this2.data);
          this2.modal_update = this2.modalService.open(content, this2.modalOptions);
          this.spinner.hide();

        });
      }
      else {
        this.fields = this.setValues(this.fields, this.data);
        this.modal_update = this.modalService.open(content, this.modalOptions);
        this.spinner.hide();
      }
    }
  }
  setValues(formField: FormField[], startingData: any): FormField[] {
    var that = this;
    var formField2: FormField[] = JSON.parse(JSON.stringify(formField));
    formField2.forEach(function (field) {
      if (field && field.type != "group" && field.path) {
        if (field.type != "image" && field.type != "checkbox")
          field.value = that.getObjectFromPath(startingData, field.path);
        else if (field.type == "checkbox")
          field.values = that.getObjectFromPath(startingData, field.path);
        else if (field.image && field.image.urlPath)
          field.image.url = that.getObjectFromPath(startingData, field.image.urlPath);
      }
      else if (field.group?.fields && field.group?.path) {
        var formFieldBase: FormField[] = JSON.parse(JSON.stringify(field.group.fields));
        var group_data_array: any[] = JSON.parse(JSON.stringify(that.getObjectFromPath(startingData, field.group.path)));
        var group_values_array: FormField[][] = [];
        group_data_array.forEach(function (current_data, index) {
          group_values_array[index] = formFieldBase;
          group_values_array[index] = that.setValues(group_values_array[index], current_data);
        })
        field.group.values = group_values_array;
      }
    })
    return formField2;
  }
  getObjectFromPath(object: any, path: string) {
    var paths: string[] = path.split(".");
    var obj = { ...object };
    for (let i = 0; i < paths.length; i++) {
      obj = obj[paths[i]];
    }
    return obj;
  }
  setModelsData(fields: FormField[]) {
    var that = this;
    fields.forEach(function (field) {
      if (field && field.type != "group" && field.optionData) {
        if (!that.models_slug.includes(field.optionData))
          that.models_slug.push(field.optionData);
      }
      else if (field.group?.fields && field.group?.path) {
        that.setModelsData(field.group.fields);
      }
    });
  }
  onSubmit($event: any) {
    this.submitted = true;
    if ($event) {
      this.apiService.update(this.slug, this.data.id, $event.value).subscribe({
        next: data => {
          if (this.route.routeConfig?.path?.split('/').slice(-1)[0].toString().includes(':')) {
            this.path.push(data.data.id);
          }
          this.modal_update.close();
          this.apiService.reload(this.slug, true).subscribe(() => {
            this.router.navigate(['/']).then(() => { this.router.navigate(this.path); })
            this.toastService.showWarningToast('AGGIORNAMENTO', 'RISORSA MODIFICATA CORRETTAMENTE!');
          });
        },
        error: error => {
          this.toastService.showErrorToast('ERRORE', 'RISORSA NON MODIFICATA! ' + error.message);
        }
      });
    }
    else {
      this.toastService.showErrorToast('ERRORE', 'Inserire tutti i campi');
    }
  }
}
