import { Component } from '@angular/core';
import { Genre } from '../../models/genre';
import { Serie } from '../../models/serie';
import { AuthService } from '../../services/auth/auth.service';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { CarouselModule } from 'ngx-owl-carousel-o';
import { BannerComponent } from '../../components/banner/banner.component';
import { SliderComponent } from '../../components/slider/slider.component';
import { BreadcrumbComponent } from '../../components/breadcrumb/breadcrumb.component';
import { ApiService } from '../../services/api/api.service';
import { FormField } from '../../models/form';
import { SerieFields } from '../../fields/serie';
import { InsertComponent } from '../../components/insert/insert.component';

@Component({
  selector: 'app-series',
  standalone: true,
  imports: [RouterLink, CommonModule, CarouselModule, BannerComponent, SliderComponent, BreadcrumbComponent, InsertComponent],
  templateUrl: './series.component.html',
  styleUrl: './series.component.scss'
})
export class SeriesComponent {
  constructor(private authService: AuthService, private apiService: ApiService) { }
  isAdmin: boolean = this.authService.isAdmin();
  series: Serie[] = [];
  genres: Genre[] = [];
  items_for_row = 5;
  sliderIsLoading = true;
  bannerIsLoading = true;
  serie_fields: FormField[] = new SerieFields().serie_fields;

  ngOnInit(): void {
    this.apiService.getSeries().subscribe((series) => {
      this.series = this.series.concat(series);;
      this.series.splice(10, this.series.length - 10);
      this.bannerIsLoading = false;
    });
    this.apiService.getGenres().subscribe((genres) => {
      this.genres = this.genres.concat(genres);
      this.genres.map((genre) => {
        this.apiService.getSeriesGenre(genre.id).subscribe((series) => {
          genre.movies = genre.movies.concat(series);
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
