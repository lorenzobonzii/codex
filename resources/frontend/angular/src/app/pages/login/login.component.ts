import { OnInit, ViewEncapsulation, inject } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, RouterLink, RouterModule } from '@angular/router';
import { AuthService } from '../../services/auth/auth.service';
import { Component } from '@angular/core';
import { ToastService } from '../../services/toast/toast.service';
import { environment } from '../../../environments/environment';
import { ApiService } from '../../services/api/api.service';
import { CommonModule } from '@angular/common';
import { FormField } from '../../models/form';
import { FormComponent } from '../../components/form/form.component';
import { LoginFields } from '../../fields/login';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule, RouterModule, CommonModule, RouterLink, FormsModule, FormComponent],
  encapsulation: ViewEncapsulation.None,
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})

export class LoginComponent {
  constructor(private authService: AuthService, private toastService: ToastService, private apiService: ApiService, private router: Router) { }
  submitted = false;
  defaultUser = this.authService.defaultUser;
  login_fields: FormField[] = new LoginFields().login_fields;

  ngOnInit(): void {
    var that = this;
    this.login_fields.forEach(function (field) {
      if (field.name == "user") {
        field.value = that.defaultUser;
      }
    })
  }

  onSubmit($event: any) {
    this.submitted = true;
    if ($event) {
      this.authService.login($event.value.user, $event.value.password).subscribe();
    }
    else {
      this.toastService.showErrorToast('Errore', 'Inserire tutti i campi.');
    }
  }
}
