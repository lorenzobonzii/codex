import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FilmsGenreComponent } from './films-genre.component';

describe('FilmsGenreComponent', () => {
  let component: FilmsGenreComponent;
  let fixture: ComponentFixture<FilmsGenreComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FilmsGenreComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FilmsGenreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
