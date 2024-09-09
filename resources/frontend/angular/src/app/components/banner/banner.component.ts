import { Component, Input } from '@angular/core';
import { Film } from '../../models/film';
import { Serie } from '../../models/serie';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';
import { CarouselModule, OwlOptions } from 'ngx-owl-carousel-o';
import { SpinnerComponent } from '../spinner/spinner.component';

@Component({
  selector: 'app-banner',
  standalone: true,
  imports: [RouterLink, CommonModule, CarouselModule, SpinnerComponent],
  templateUrl: './banner.component.html',
  styleUrl: './banner.component.scss'
})
export class BannerComponent {
  constructor(private router: Router) { }

  @Input() movies: Array<Film | Serie> = [];
  @Input() isLoading: boolean = false;


  carouselOptionsSingleItem: OwlOptions = {
    loop: true,
    mouseDrag: false,
    touchDrag: false,
    pullDrag: false,
    dots: false,
    //nav: true,
    navSpeed: 700,
    //navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    items: 1,
    autoplay: true,
    autoplayTimeout: 10000,
    autoplaySpeed: 1000,
    autoplayHoverPause: true
  }

  public showAnteprima(id_movie: number) {
    var anteprima!: string;
    this.movies?.map((movie) => {
      if (movie.id == id_movie) {
        anteprima = movie.anteprima;
      }
    });
    var img = document.getElementById("img-" + id_movie);
    var player = document.getElementById("player-" + id_movie);
    img!.style.display = "none";
    player!.style.display = "block";
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
