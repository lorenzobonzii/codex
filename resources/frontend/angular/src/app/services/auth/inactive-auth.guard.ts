import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';
import { inject } from '@angular/core';

export const inactiveAuthGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isAuthenticated() || (authService.isAuthenticated() && !authService.isActiveAuthenticated())) {
    return true;
  }
  router.navigate(['/browse']);
  return false;
};
