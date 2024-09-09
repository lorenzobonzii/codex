import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CarouselModule } from 'ngx-owl-carousel-o';
import { BannerComponent } from '../../components/banner/banner.component';
import { SliderComponent } from '../../components/slider/slider.component';
import { AuthService } from '../../services/auth/auth.service';
import { Film } from '../../models/film';
import { Genre } from '../../models/genre';
import { BreadcrumbComponent } from '../../components/breadcrumb/breadcrumb.component';
import { ApiService } from '../../services/api/api.service';
import { InsertComponent } from '../../components/insert/insert.component';
import { FormField } from '../../models/form';
import { FilmFields } from '../../fields/film';

@Component({
  selector: 'app-films',
  standalone: true,
  imports: [RouterLink, CommonModule, BannerComponent, SliderComponent, BreadcrumbComponent, InsertComponent],
  templateUrl: './films.component.html',
  styleUrl: './films.component.scss'
})
export class FilmsComponent {
  constructor(private authService: AuthService, private apiService: ApiService) { }
  isAdmin: boolean = this.authService.isAdmin();
  films: Film[] = [];
  genres: Genre[] = [];
  items_for_row = 5;
  sliderIsLoading = true;
  bannerIsLoading = true;
  film_fields: FormField[] = new FilmFields().film_fields;

  ngOnInit(): void {
    this.apiService.getFilms().subscribe((films) => {
      this.films = this.films.concat(films);
      this.films.splice(10, this.films.length - 10);
      this.bannerIsLoading = false;
    });
    this.apiService.getGenres().subscribe((genres) => {
      this.genres = genres;
      this.genres.map((genre) => {
        this.apiService.getFilmsGenre(genre.id).subscribe((films) => {
          genre.movies = genre.movies.concat(films);
          var original_length = genre.movies.length;
          while (genre.movies.length > 0 && genre.movies.length < this.items_for_row) {
            for (var i = 0; i < original_length; i++) {
              genre.movies.push(genre.movies[i]);
            }
          }
          genre.movies.splice(10, genre.movies.length - 10);
          this.sliderIsLoading = false;
        });
      });
    });
  }
}
