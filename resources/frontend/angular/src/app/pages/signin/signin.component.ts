import { Component, ViewEncapsulation, inject } from '@angular/core';
import { FormComponent } from '../../components/form/form.component';
import { FormField, SelectOption } from '../../models/form';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth/auth.service';
import { ToastService } from '../../services/toast/toast.service';
import { ApiService } from '../../services/api/api.service';
import { Router } from '@angular/router';
import { UserFields } from '../../fields/user';
import { combineLatest } from 'rxjs';

@Component({
  selector: 'app-signin',
  standalone: true,
  imports: [FormComponent, ReactiveFormsModule, FormsModule],
  encapsulation: ViewEncapsulation.None,
  templateUrl: './signin.component.html',
  styleUrl: './signin.component.scss'
})
export class SigninComponent {
  constructor(private authService: AuthService, private toastService: ToastService, private apiService: ApiService, private router: Router) { }
  submitted = false;
  defaultUser = this.authService.defaultUser;
  user_fields: FormField[] = new UserFields().user_limited_fields;
  modal_insert!: any;
  isLoading: boolean = false;
  models_slug: FormField["optionData"][] = [];
  optionsData: SelectOption[][] = [];

  ngOnInit(): void {
    var that = this;
    this.user_fields.forEach(function (field) {
      if (field.name == "user") {
        field.value = that.defaultUser;
      }
    });
    this.models_slug = [];
    this.optionsData = [];
    if (this.user_fields) {
      this.setModelsData(this.user_fields);
      if (this.models_slug.length > 0) {
        const observables = this.models_slug.map((slug: FormField["optionData"]) => (
          that.apiService.get(slug?.slug)
        ));
        combineLatest(observables).subscribe((values) => {
          values.forEach(function (results, index) {
            let slug = that.models_slug[index];
            that.optionsData[slug?.slug] = results.data.map((x: any) => ({ label: x[slug?.slug_label!], value: x[slug?.slug_value!] }));
          });
        });
      }
    }
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
      this.apiService.signin($event.value).subscribe((data: any) => {
        this.router.navigate(['/']);
        this.toastService.showSuccessToast('INSERIMENTO', 'UTENTE CREATO CORRETTAMENTE!');
      });
    }
    else {
      this.toastService.showErrorToast('ERRORE', 'Inserire tutti i campi.');
    }
  }
}
