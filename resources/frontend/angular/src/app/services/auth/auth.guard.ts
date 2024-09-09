import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';
import { inject } from '@angular/core';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isActiveAuthenticated()) {
    return true;
  } else if (authService.isAuthenticated() && authService.isInactiveAuthenticated()) {
    router.navigate(['/account']);
    return false;
  } else if (authService.isAuthenticated() && !authService.isActiveAuthenticated()) {
    router.navigate(['/logout']);
    return false;
  }
  router.navigate(['/home']);
  return false;
};
