import { Component, inject } from '@angular/core';
import { AuthService } from '../../services/auth/auth.service';
import { CommonModule } from '@angular/common';
import { NavigationEnd, Router, RouterLink, RouterLinkActive } from '@angular/router';
import { environment } from '../../../environments/environment';
import { User } from '../../models/user';
import { pipe } from 'rxjs';
@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule, RouterLink, RouterLinkActive],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss'
})
export class NavbarComponent {
  constructor(private router: Router, private authService: AuthService) { }
  isAuthenticated: boolean = false;
  isActiveAuthenticated: boolean = false;
  isAdmin: boolean = false;
  user!: User | null;

  ngOnInit(): void {
    this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd) {
        if (this.authService.isAuthenticated()) {
          this.isAuthenticated = true;
          if (this.authService.isActiveAuthenticated()) {
            this.isActiveAuthenticated = true;
          }
          else {
            this.isActiveAuthenticated = false;
          }
          if (this.authService.isAdmin()) {
            this.isAdmin = true;
          }
          else {
            this.isAdmin = false;
          }
          this.authService.currentUser.subscribe({
            next: user => {
              this.user = user;
            },
            error: error => {
              this.logout();
            }
          });
        }
        else {
          this.isAdmin = false;
          this.isAuthenticated = false;
          this.isActiveAuthenticated = false;
        }
      }
    })
  }

  logout() {
    return this.authService.logout();
  }

  filter(text: string, e: Event) {
    e.preventDefault();
    if (!text) {
      return;
    }
    this.router.navigate(
      ['/search'],
      { queryParams: { key: text } }
    );
  }

}
