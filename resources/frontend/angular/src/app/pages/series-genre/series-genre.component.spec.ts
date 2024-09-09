import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SeriesGenreComponent } from './series-genre.component';

describe('SeriesGenreComponent', () => {
  let component: SeriesGenreComponent;
  let fixture: ComponentFixture<SeriesGenreComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SeriesGenreComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SeriesGenreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
