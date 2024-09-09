import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Observable, BehaviorSubject, throwError, of } from 'rxjs';
import { catchError, map, retry, switchMap, tap } from 'rxjs/operators';
import { SaleResponse, LoginResponse } from './auth.interface';
import { environment } from '../../../environments/environment';
import CryptoJS from 'crypto-js';
import { Router } from '@angular/router';
import { ToastService } from '../toast/toast.service';
import { HttpCancelService } from './http-cancel.service';
import { User } from '../../models/user';
import { Role } from '../../models/role';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = environment.apiUrl;
  private router = inject(Router);
  private toastService = inject(ToastService);
  private httpCancelService = inject(HttpCancelService);

  private currentUserSubject: BehaviorSubject<User | null>;
  public currentUser: Observable<User | null>;
  defaultUser: string = '';
  constructor(private http: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<User | null>(JSON.parse(localStorage.getItem(environment.cookieUser)!));
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): User | null {
    return this.currentUserSubject.value;
  }

  getSale(username: any): Observable<SaleResponse> {
    return this.http.post<SaleResponse>(`${this.apiUrl}/login`, { username: username });
  }

  login(username: any, password: any): Observable<LoginResponse> {
    return this.getSale(CryptoJS.SHA512(username).toString()).pipe(
      switchMap(saleResponse => {
        const saltedPassword = CryptoJS.SHA512(CryptoJS.SHA512(password) + saleResponse.data.sale).toString();
        return this.http.post<LoginResponse>(`${this.apiUrl}/login`, { username: username, hashedPassword: saltedPassword });
      }),
      tap(response => {
        localStorage.setItem(environment.cookieJwt, response.data.token_jwt);
        localStorage.setItem(environment.cookieUserId, response.data.user_id);
        this.getCurrentUser().subscribe(() => {
          if (this.isAuthenticated()) {
            this.router.navigate(['/']);
          }
        });
        //this.verifyToken().subscribe();

      })
    );
  }

  logout() {
    localStorage.removeItem(environment.cookieJwt);
    localStorage.removeItem(environment.cookieUser);
    localStorage.removeItem(environment.cookieUserId);
    localStorage.removeItem(environment.cookieUserRole);
    localStorage.removeItem(environment.cookieUserState);
    this.currentUserSubject.next(null);
    this.httpCancelService.cancelPendingRequests();
    this.router.navigate(['/']);
    this.toastService.showErrorToast('LOGOUT', 'UTENTE DISCONNESSO');
  }

  getCurrentUser(): Observable<User> {
    const user_id = localStorage.getItem(environment.cookieUserId);
    return this.http.get<{ data: User }>(`${this.apiUrl}/users/${user_id}`).pipe(
      tap(user => {
        localStorage.setItem(environment.cookieUser, JSON.stringify(user.data));
        localStorage.setItem(environment.cookieUserRole, user.data.role_id.toString());
        localStorage.setItem(environment.cookieUserState, user.data.state_id.toString());
        let nome = JSON.parse(localStorage.getItem(environment.cookieUser) ?? '').person.nome;
        this.toastService.showSuccessToast('Benvenuto', "Benvenuto, " + nome + "!");
        this.currentUserSubject.next(user.data);
      }),
      map(user => user.data)
    );
  }
  getUser(): Observable<User> {
    const user_id = localStorage.getItem(environment.cookieUserId);
    return this.http.get<{ data: User }>(`${this.apiUrl}/users/${user_id}`).pipe(
      map(user => user.data)
    );
  }

  verifyToken(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/verifyToken`, {
      headers: new HttpHeaders().set('Authorization', `Bearer ${localStorage.getItem(environment.cookieJwt)}`)
    }).pipe(tap(data => {
    }));
  }

  isAuthenticated(): boolean {
    return !!localStorage.getItem(environment.cookieJwt);
  }

  isValidAuthentication(): boolean {
    if (localStorage.getItem(environment.cookieJwt)) {
      this.http.get<any>(`${this.apiUrl}/verifyToken`);
      return true;
    }
    else
      return false;

  }

  isActiveAuthenticated(): boolean {
    if (localStorage.getItem(environment.cookieJwt)) {
      if (localStorage.getItem(environment.cookieUserState)) {
        let state_id = Number.parseInt(localStorage.getItem(environment.cookieUserState) ?? '');
        if (state_id === 1) {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        return this.isActiveAuthenticated();
      }
    }
    else
      return false;
  }

  isInactiveAuthenticated(): boolean {
    if (localStorage.getItem(environment.cookieJwt)) {
      if (localStorage.getItem(environment.cookieUserState)) {
        let state_id = Number.parseInt(localStorage.getItem(environment.cookieUserState) ?? '');
        if (state_id === 2) {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        return this.isInactiveAuthenticated();
      }
    }
    else
      return false;
  }

  isAdmin(): boolean {
    if (localStorage.getItem(environment.cookieJwt)) {
      if (localStorage.getItem(environment.cookieUserRole)) {
        let role_id = Number.parseInt(localStorage.getItem(environment.cookieUserRole) ?? '');
        if (role_id === 1) {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        return this.isAdmin();
      }
    }
    else
      return false;
  }
}
