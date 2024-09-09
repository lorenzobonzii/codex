import { HttpClient, HttpErrorResponse, HttpHeaders, HttpResponse } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { environment } from '../../../environments/environment';
import { forkJoin, map, Observable, shareReplay } from 'rxjs';
import { ToastService } from '../toast/toast.service';
import { Response } from '../../models/response';
import { AuthService } from '../auth/auth.service';
import { SigninRequest } from '../../models/signinRequest';
import { Genre } from '../../models/genre';
import { Film } from '../../models/film';
import { Serie } from '../../models/serie';
import { Option } from '../../models/option';
import { User } from '../../models/user';
import { Nation } from '../../models/nation';
import { Municipality } from '../../models/municipality';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private http: HttpClient, private toastService: ToastService, private auth: AuthService) {
    this.getGenres();
    this.getFilms();
    this.getSeries();
  }

  private apiUrl = environment.apiUrl;

  creaUrl(paths: Array<string>): string {
    let url = this.apiUrl;
    paths.forEach(function (path) {
      url = url + '/' + path;
    })
    return url;
  }
  req(method: "GET" | "POST" | "DELETE" | "PUT", paths: Array<string>, body?: any) {
    let url = this.creaUrl(paths);
    switch (method) {
      case "GET":
        return this.http.get<Response>(url);
      case "POST":
        return this.http.post<Response>(url, body);
      case "PUT":
        return this.http.put<Response>(url, body);
      case "DELETE":
        return this.http.delete<Response>(url);
    }
  }
  signin(data: SigninRequest): Observable<any> {
    return this.http.post(`${this.apiUrl}/signup`, data);
  }
  shuffle = (array: any[]) => {
    return array.map((a) => ({ sort: Math.random(), value: a }))
      .sort((a, b) => a.sort - b.sort)
      .map((a) => a.value);
  }

  private observable$!: Observable<any>;
  reload(slug: string, $clearcache = false): Observable<any> {
    if (!this.observable$ || $clearcache) {
      this.observable$ = this.http.get<{ data: any[] }>(this.creaUrl([slug])).pipe(
        map(res => res.data),
        shareReplay(1) // Cache the preferences
      );
    }
    if (slug == "genres") {
      this.genres$ = this.getGenres();
      return this.genres$;
    }
    if (slug == "films") {
      this.films$ = this.getFilms(true);
      return this.films$;
    }
    if (slug == "series") {
      this.series$ = this.getSeries(true);
      return this.series$;
    }
    if (slug == "options") {
      this.options$ = this.getOptions(true);
      return this.options$;
    }
    if (slug == "users") {
      this.users$ = this.getUsers(true);
      return this.users$;
    }
    if (slug == "profile") {
      return this.auth.getUser();
    }
    if (slug == "nations") {
      this.nations$ = this.getNations(true);
      return this.nations$;
    }
    if (slug == "municipalities") {
      this.municipalities$ = this.getMunicipalities(true);
      return this.municipalities$;
    }
    return this.observable$;
  }
  get(slug: string): Observable<any> {
    return this.http.get(this.creaUrl([slug]));
  }
  insert(slug: string, data: any): Observable<any> {
    return this.http.post(this.creaUrl([slug]), data);
  }
  update(slug: string, id: number, data: any): Observable<any> {
    return this.http.put(this.creaUrl([slug, id.toString()]), data);
  }
  delete(slug: string, id: number): Observable<any> {
    return this.http.delete(this.creaUrl([slug, id.toString()]));
  }

  //GENRES
  private genres$!: Observable<Genre[]>;

  getGenres(): Observable<Genre[]> {
    //if (!this.genres$) {
    // this.genres$ =
    return this.http.get<{ data: Genre[] }>(this.creaUrl(['genres'])).pipe(
      map((res) => {
        var genres: Genre[] = res.data;
        genres.forEach(function (genre) {
          genre.movies = [];
        })
        return genres;
      }),
      //shareReplay(1) // Cache the preferences
    );
    //}
    //return this.genres$;
  }
  getGenre(genre_id: number): Observable<Genre> {
    return this.getGenres().pipe(
      map(list => {
        const found = list.find((({ id }) => id == genre_id));
        if (found) {
          return found;
        }
        throw console.error('Genre not found');
      })
    );
  }

  // FILMS
  private films$!: Observable<Film[]>;

  getFilms($clearcache = false): Observable<Film[]> {
    if (!this.films$ || $clearcache) {
      this.films$ = this.http.get<{ data: Film[] }>(this.creaUrl(['films'])).pipe(
        map(res => {
          var films: Film[] = this.shuffle(res.data);
          return films;
        }),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.films$;
  }
  getFilm(film_id: number): Observable<Film> {
    return this.getFilms().pipe(
      map(list => {
        const found = list.find((({ id }) => id == film_id));
        if (found) {
          return found;
        }
        throw console.error('Film not found');
      })
    );
  }
  getFilmsGenre(genre_id: number): Observable<Film[]> {
    return this.getFilms().pipe(
      map(list => {
        if (list && list.length > 0) {
          const res = list.filter(
            item => item.genres.find(genre => genre.id === genre_id)
          )
          if (res) {
            return res;
          }
        }
        throw console.error('Films not found');
      })
    );
  }

  // SERIES
  private series$!: Observable<Serie[]>;

  getSeries($clearcache = false): Observable<Serie[]> {
    if (!this.series$ || $clearcache) {
      this.series$ = this.http.get<{ data: Serie[] }>(this.creaUrl(['series'])).pipe(
        //map(res => res.data),
        map((res) => {
          var series: Serie[] = this.shuffle(res.data);
          series.forEach(function (serie) {
            serie.seasons = [];
          })
          return series;
        }),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.series$;
  }
  getSerieApi(serie_id: number): Observable<Serie> {
    return this.http.get<{ data: Serie }>(this.creaUrl(['series', serie_id.toString()])).pipe(
      map(res => res.data)
    );
  }
  getSerie(serie_id: number): Observable<Serie> {
    return this.getSeries().pipe(
      map(list => {
        const found = list.find((({ id }) => id == serie_id));
        if (found) {
          return found;
        }
        throw console.error('Serie not found');
      })
    );
  }
  getSeriesGenre(genre_id: number): Observable<Serie[]> {
    return this.getSeries().pipe(
      map(list => {
        if (list.length > 0) {
          const res = list.filter(
            item => item.genres.find(genre => genre.id === genre_id)
          )
          if (res) {
            return res;
          }
        }
        throw console.error('Series not found');
      })
    );
  }

  // TUTTO
  getAll(max_items?: number): Observable<(Film | Serie)[]> {
    return forkJoin([this.getFilms(), this.getSeries()])
      .pipe(
        map(([films, series]) => {
          var movies: (Serie | Film)[] = films;
          movies = movies.concat(series);
          movies = this.shuffle(movies);
          return movies;
        })
      )
  }

  // USERS
  private users$!: Observable<User[]>;

  getUsers($clearcache = false): Observable<User[]> {
    if (!this.users$ || $clearcache) {
      this.users$ = this.http.get<{ data: User[] }>(this.creaUrl(['users'])).pipe(
        map(res => res.data),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.users$;
  }
  getUser(user_id: number): Observable<User> {
    return this.getUsers().pipe(
      map(list => {
        const found = list.find((({ id }) => id == user_id));
        if (found) {
          return found;
        }
        throw console.error('User not found');
      })
    );
  }

  // OPTIONS
  private options$!: Observable<Option[]>;

  getOptions($clearcache = false): Observable<Option[]> {
    if (!this.options$ || $clearcache) {
      this.options$ = this.http.get<{ data: Option[] }>(this.creaUrl(['options'])).pipe(
        map(res => res.data),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.options$;
  }
  getOption(option_id: number): Observable<Option> {
    return this.getOptions().pipe(
      map(list => {
        const found = list.find((({ id }) => id == option_id));
        if (found) {
          return found;
        }
        throw console.error('Option not found');
      })
    );
  }

  // NATIONS
  private nations$!: Observable<Nation[]>;

  getNations($clearcache = false): Observable<Nation[]> {
    if (!this.nations$ || $clearcache) {
      this.nations$ = this.http.get<{ data: Nation[] }>(this.creaUrl(['nations'])).pipe(
        map(res => res.data),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.nations$;
  }
  getNation(nation_id: number): Observable<Nation> {
    return this.getNations().pipe(
      map(list => {
        const found = list.find((({ id }) => id == nation_id));
        if (found) {
          return found;
        }
        throw console.error('Nation not found');
      })
    );
  }

  // MUNICIPALITIES
  private municipalities$!: Observable<Municipality[]>;

  getMunicipalities($clearcache = false): Observable<Municipality[]> {
    if (!this.municipalities$ || $clearcache) {
      this.municipalities$ = this.http.get<{ data: Municipality[] }>(this.creaUrl(['municipalities'])).pipe(
        map(res => res.data),
        shareReplay(1) // Cache the preferences
      );
    }
    return this.municipalities$;
  }
  getMunicipality(nation_id: number): Observable<Municipality> {
    return this.getMunicipalities().pipe(
      map(list => {
        const found = list.find((({ id }) => id == nation_id));
        if (found) {
          return found;
        }
        throw console.error('Municipality not found');
      })
    );
  }
}
