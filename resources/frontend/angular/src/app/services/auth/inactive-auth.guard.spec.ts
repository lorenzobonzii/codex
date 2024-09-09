import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';
import { inactiveAuthGuard } from './inactive-auth.guard';

describe('inactiveAuthGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) =>
    TestBed.runInInjectionContext(() => inactiveAuthGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
