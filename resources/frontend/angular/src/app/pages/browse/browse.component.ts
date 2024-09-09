import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { AuthService } from '../../services/auth/auth.service';
import { CarouselModule, OwlOptions } from 'ngx-owl-carousel-o';
import { Genre } from '../../models/genre';
import { Film } from '../../models/film';
import { Serie } from '../../models/serie';
import { RouterLink } from '@angular/router';
import { BannerComponent } from '../../components/banner/banner.component';
import { SliderComponent } from '../../components/slider/slider.component';
import { ApiService } from '../../services/api/api.service';

@Component({
  selector: 'app-browse',
  standalone: true,
  imports: [RouterLink, CommonModule, CarouselModule, BannerComponent, SliderComponent],
  templateUrl: './browse.component.html',
  styleUrl: './browse.component.scss'
})
export class BrowseComponent {
  constructor(private authService: AuthService, private apiService: ApiService) { }

  movies: (Film | Serie)[] = [];
  genres: Genre[] = [];
  items_for_row = 5;
  bannerIsLoading = true;
  sliderIsLoading = true;


  ngOnInit(): void {
    this.apiService.getAll().subscribe((movies) => {
      this.movies = this.movies.concat(movies);
      this.movies.splice(10, this.movies.length - 10);
      this.bannerIsLoading = false;
    });
    this.apiService.getGenres().subscribe((genres) => {
      this.genres = this.genres.concat(genres);
      this.genres.map((genre) => {
        this.apiService.getFilmsGenre(genre.id).subscribe((films) => {
          genre.movies = genre.movies.concat(films);
          this.apiService.getSeriesGenre(genre.id).subscribe((series) => {
            genre.movies = genre.movies.concat(series);
            genre.movies = this.apiService.shuffle(genre.movies);
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
      })
    });
  }
}
