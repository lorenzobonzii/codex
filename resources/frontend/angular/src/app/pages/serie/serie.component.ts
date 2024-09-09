import { CommonModule } from '@angular/common';
import { Component, ViewChild } from '@angular/core';
import { ActivatedRoute, Router, RouterLink, RouterModule } from '@angular/router';
import { AuthService } from '../../services/auth/auth.service';
import { Serie } from '../../models/serie';
import { SliderComponent } from '../../components/slider/slider.component';
import { BannerComponent } from '../../components/banner/banner.component';
import { PlayerComponent } from '../../components/player/player.component';
import { BreadcrumbComponent } from '../../components/breadcrumb/breadcrumb.component';
import { Season } from '../../models/season';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../services/api/api.service';
import { FormField } from '../../models/form';
import { SerieFields } from '../../fields/serie';
import { ActionsComponent } from '../../components/actions/actions.component';
import { NgxSpinnerComponent, NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-serie',
  standalone: true,
  imports: [CommonModule, RouterModule, RouterLink, BreadcrumbComponent, SliderComponent, BannerComponent, PlayerComponent, FormsModule, ActionsComponent, NgxSpinnerComponent],
  templateUrl: './serie.component.html',
  styleUrl: './serie.component.scss'
})
export class SerieComponent {
  constructor(private authService: AuthService, private apiService: ApiService, private router: Router, private activatedRoute: ActivatedRoute, private spinner: NgxSpinnerService) { }
  @ViewChild('appPlayer') appPlayer!: PlayerComponent;

  isAdmin: boolean = this.authService.isAdmin();
  id_serie!: number;
  serie!: Serie;
  serie_fields: FormField[] = new SerieFields().serie_fields;
  items_for_row = 5;
  isLoading = true;
  titolo = ["Episodi"];
  current_season!: Season | undefined;

  ngOnInit(): void {
    this.spinner.show();
    this.activatedRoute.params.subscribe(params => {
      this.id_serie = params['id'];
      this.apiService.getSerieApi(this.id_serie).subscribe((serie) => {
        this.serie = serie;
        this.current_season = serie.seasons[0];
        this.serie.genres.map((genre) => {
          this.apiService.getSeriesGenre(genre.id).subscribe((series) => {
            genre.movies = series;
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
