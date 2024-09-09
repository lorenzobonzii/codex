import { CommonModule } from '@angular/common';
import { Component, ViewChild } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { Film } from '../../models/film';
import { Genre } from '../../models/genre';
import { SliderComponent } from '../../components/slider/slider.component';
import { BannerComponent } from '../../components/banner/banner.component';
import { PlayerComponent } from '../../components/player/player.component';
import { ApiService } from '../../services/api/api.service';
import { AuthService } from '../../services/auth/auth.service';
import { FormField } from '../../models/form';
import { FilmFields } from '../../fields/film';
import { ActionsComponent } from '../../components/actions/actions.component';
import { NgxSpinnerComponent, NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-film',
  standalone: true,
  imports: [CommonModule, RouterLink, SliderComponent, BannerComponent, PlayerComponent, ActionsComponent, NgxSpinnerComponent],
  templateUrl: './film.component.html',
  styleUrl: './film.component.scss'
})
export class FilmComponent {
  constructor(private authService: AuthService, private apiService: ApiService, private router: Router, private route: ActivatedRoute, private spinner: NgxSpinnerService) { }
  @ViewChild('appPlayer') appPlayer!: PlayerComponent;

  isAdmin: boolean = this.authService.isAdmin();
  id_film!: number;
  film!: Film;
  film_fields: FormField[] = new FilmFields().film_fields;
  items_for_row = 5;
  isLoading = true;

  ngOnInit(): void {
    this.spinner.show();
    this.route.params.subscribe(params => {
      this.id_film = params['id'];
      this.apiService.getFilm(this.id_film).subscribe((film) => {
        this.film = film;
        this.film.genres.map((genre) => {
          this.apiService.getFilmsGenre(genre.id).subscribe((films) => {
            genre.movies = films;
            var original_length = genre.movies.length;
            while (genre.movies.length > 0 && genre.movies.length < this.items_for_row) {
              for (var i = 0; i < original_length; i++) {
                genre.movies.push(genre.movies[i]);
              }
            }
            genre.movies.splice(10, genre.movies.length - 10);
            this.isLoading = false;
            this.spinner.hide();
          });
        });
      });
    });
  }

  changePlayVideo() {
    this.appPlayer.changeStatusPlay();
  }
  watch(id: string, e: Event) {
    e.preventDefault();
    if (!id) {
      return;
    }
    this.router.navigate(
      ['/watch'],
      { queryParams: { videoId: id } }
    );
  }
}
