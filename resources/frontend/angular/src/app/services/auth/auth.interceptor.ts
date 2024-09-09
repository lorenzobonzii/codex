import { Injectable, inject } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor, HttpErrorResponse } from '@angular/common/http';
import { Observable, catchError, takeUntil, throwError } from 'rxjs';
import { AuthService } from './auth.service';
import { HttpCancelService } from './http-cancel.service';
import { ToastService } from '../toast/toast.service';

import { environment } from '../../../environments/environment';

@Injectable()
export class AuthInterceptorDI implements HttpInterceptor {
  toastService = inject(ToastService);
  authService = inject(AuthService);
  httpCancelService = inject(HttpCancelService);
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = localStorage.getItem(environment.cookieJwt);
    if (token) {
      req = req.clone({
        setHeaders: {
          Authorization: `Bearer ${token}`
        }
      });
    }
    return next.handle(req).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.error.message)
          var message: string = error.error.message;
        else
          var message: string = error.message;

        if (error.status == 400) {
          this.authService.logout();
          this.toastService.showErrorToast('Errore', "Errore nella richiesta al server", message);
        }
        if (error.status == 401) {
          this.authService.logout();
          this.toastService.showErrorToast('Errore', "Errore nella richiesta al server: sessione non valida, riaccedi!");
        }
        if (error.status == 403) {
          this.toastService.showErrorToast('Errore', "Errore nella richiesta al server: utente non autorizzato", message);
        }
        if (error.status == 404) {
          this.toastService.showErrorToast('Errore', "Errore nella richiesta al server: risorsa non trovata.", message);
        }
        if (error.status == 500) {
          this.toastService.showErrorToast('Errore', "Errore nella richiesta al server: servizio non disponibile.", message);
        }
        if (error.status == 422) {
          var html = "<ul>";

          Object.entries(error.error.errors)
            .forEach(([key, errs]) => {
              //@ts-ignore
              errs.forEach(function (err) {
                html += "<li>" + err + "</li>";
              })
            });
          html += "</ul>";
          this.toastService.showErrorToast('Errore', "Errore nella richiesta.", html);
        }
        return throwError(() => error);
      }),
      takeUntil(this.httpCancelService.onCancelPendingRequests())
    );
  }
}
