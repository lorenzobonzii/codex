import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BiggerSpinnerComponent } from './bigger-spinner.component';

describe('BiggerSpinnerComponent', () => {
  let component: BiggerSpinnerComponent;
  let fixture: ComponentFixture<BiggerSpinnerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BiggerSpinnerComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BiggerSpinnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
