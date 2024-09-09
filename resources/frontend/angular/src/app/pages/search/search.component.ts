import { Component } from '@angular/core';
import { Serie } from '../../models/serie';
import { Film } from '../../models/film';
import { ApiService } from '../../services/api/api.service';
import { ActivatedRoute, ParamMap, RouterLink, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { map, Observable } from 'rxjs';
import { SpinnerComponent } from '../../components/spinner/spinner.component';

@Component({
  selector: 'app-search',
  standalone: true,
  imports: [CommonModule, RouterModule, RouterLink, SpinnerComponent],
  templateUrl: './search.component.html',
  styleUrl: './search.component.scss'
})
export class SearchComponent {
  constructor(private apiService: ApiService, private route: ActivatedRoute) { }
  key$!: Observable<string>;
  movies!: Film[] | Serie[];
  isLoading = true;

  ngOnInit(): void {
    this.key$ = this.route.queryParamMap.pipe(
      map((params: ParamMap) => params.get('key') ?? ''),
    );
    this.key$.subscribe(key => {
      this.apiService.getAll().subscribe((movies) => {
        let movies_filtered: Film[] | Serie[] = [];
        movies.forEach(function (movie) {
          if (movie.titolo.toLowerCase().includes(key.toLowerCase())) {
            movies_filtered.push(movie);
          }
        })
        this.movies = movies_filtered;
        this.isLoading = false;
      });
    });
  }
  /*
      this.route.params.subscribe(params => {
        this.key = "" + params['key'];
        this.apiService.getAll().subscribe((movies) => {
          let movies_filtered: Film[] | Serie[] = [];
          let key = this.key;
          movies.forEach(function (movie) {
            if (movie.titolo.toLowerCase().includes(key.toLowerCase())) {
              movies_filtered.push(movie);
            }
          })
          this.movies = movies_filtered;
          this.isLoading = false;
        });
      });
      */
}
