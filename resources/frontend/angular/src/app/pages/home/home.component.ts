import { Component, ViewEncapsulation, inject } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { AuthService } from '../../services/auth/auth.service';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { Observable, catchError, tap } from 'rxjs';
import { HttpErrorResponse } from '@angular/common/http';
import CryptoJS from 'crypto-js';
import { FormField } from '../../models/form';
import { FormComponent } from '../../components/form/form.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule, FormComponent, FormsModule],
  encapsulation: ViewEncapsulation.None,
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
  constructor(private authService: AuthService, private router: Router) { }
  submitted = false;

  fields: FormField[] = [
    {
      name: 'user',
      type: "email",
      placeholder: "E-mail",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "L'email è richiesta"
        },
        {
          name: "email",
          validator: "email",
          message: "Formato email non valido"
        }
      ]
    },
  ];

  onSubmit($event: any) {
    this.submitted = true;
    if ($event) {
      this.authService.getSale(CryptoJS.SHA512($event.value.user).toString()).subscribe(
        response => {
          this.authService.defaultUser = $event.value.user;
          this.router.navigate(['/login']);
        },
        error => {
          this.authService.defaultUser = $event.value.user;
          this.router.navigate(['/signin']);
        }
      );
    }
  }
}
