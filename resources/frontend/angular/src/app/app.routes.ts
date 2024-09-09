import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { LogoutComponent } from './pages/logout/logout.component';
import { HomeComponent } from './pages/home/home.component';
import { authGuard } from './services/auth/auth.guard';
import { noAuthGuard } from './services/auth/no-auth.guard';
import { adminAuthGuard } from './services/auth/admin-auth.guard';
import { BrowseComponent } from './pages/browse/browse.component';
import { FilmsComponent } from './pages/films/films.component';
import { SeriesComponent } from './pages/series/series.component';
import { SigninComponent } from './pages/signin/signin.component';
import { FilmComponent } from './pages/film/film.component';
import { SerieComponent } from './pages/serie/serie.component';
import { FilmsGenreComponent } from './pages/films-genre/films-genre.component';
import { SeriesGenreComponent } from './pages/series-genre/series-genre.component';
import { AccountComponent } from './pages/account/account.component';
import { SettingsComponent } from './pages/settings/settings.component';
import { SearchComponent } from './pages/search/search.component';
import { WatchComponent } from './pages/watch/watch.component';
import { inactiveAuthGuard } from './services/auth/inactive-auth.guard';


export const routes: Routes = [
  { path: '', component: HomeComponent, canActivate: [noAuthGuard] },
  { path: 'home', component: HomeComponent, canActivate: [noAuthGuard] },
  { path: 'signin', component: SigninComponent, canActivate: [noAuthGuard] },
  { path: 'login', component: LoginComponent, canActivate: [noAuthGuard] },
  { path: 'logout', component: LogoutComponent, canActivate: [authGuard] },
  { path: 'search', component: SearchComponent, canActivate: [authGuard] },
  { path: 'watch', component: WatchComponent, canActivate: [authGuard] },
  { path: 'account', component: AccountComponent, canActivate: [inactiveAuthGuard] },
  { path: 'settings', component: SettingsComponent, canActivate: [adminAuthGuard] },
  { path: 'browse', component: BrowseComponent, canActivate: [authGuard] },
  { path: 'browse/films', component: FilmsComponent, canActivate: [authGuard] },
  { path: 'browse/films/:id', component: FilmComponent, canActivate: [authGuard] },
  { path: 'browse/genres/films/:id', component: FilmsGenreComponent, canActivate: [authGuard] },
  { path: 'browse/series', component: SeriesComponent, canActivate: [authGuard] },
  { path: 'browse/series/:id', component: SerieComponent, canActivate: [authGuard] },
  { path: 'browse/genres/series/:id', component: SeriesGenreComponent, canActivate: [authGuard] },
];
