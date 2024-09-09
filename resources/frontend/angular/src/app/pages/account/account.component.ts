import { CommonModule } from '@angular/common';
import { Component, ViewEncapsulation } from '@angular/core';
import { TableComponent } from '../../components/table/table.component';
import { ApiService } from '../../services/api/api.service';
import { User } from '../../models/user';
import { AuthService } from '../../services/auth/auth.service';
import { ActivatedRoute } from '@angular/router';
import { FormField } from '../../models/form';
import { UserFields } from '../../fields/user';
import { UpdateComponent } from '../../components/update/update.component';

@Component({
  selector: 'app-account',
  standalone: true,
  imports: [CommonModule, TableComponent, UpdateComponent],
  templateUrl: './account.component.html',
  styleUrl: './account.component.scss'
})
export class AccountComponent {
  constructor(private authService: AuthService, private apiService: ApiService, private activatedRoute: ActivatedRoute) { }
  user!: User | null;
  user_fields: FormField[] = new UserFields().user_limited_fields;
  isActiveAuthenticated: boolean = false;
  ngOnInit(): void {
    this.authService.getUser().subscribe((user) => {
      this.user = user;
    });
    if (this.authService.isAuthenticated() && this.authService.isActiveAuthenticated()) {
      this.isActiveAuthenticated = true;
    } else {
      this.isActiveAuthenticated = false;
    }
  }
}
