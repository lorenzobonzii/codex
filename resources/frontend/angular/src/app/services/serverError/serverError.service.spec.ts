import { TestBed } from '@angular/core/testing';

import { ServerErrorService } from './serverError.service';

describe('ErrorService', () => {
  let service: ServerErrorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ServerErrorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
