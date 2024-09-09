import { CommonModule } from '@angular/common';
import { Component, Input } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { CarouselModule, OwlOptions } from 'ngx-owl-carousel-o';
import { Genre } from '../../models/genre';
import { SpinnerComponent } from '../spinner/spinner.component';
import { PlayerComponent } from '../player/player.component';

@Component({
  selector: 'app-slider',
  standalone: true,
  imports: [RouterLink, CommonModule, CarouselModule, SpinnerComponent, PlayerComponent],
  templateUrl: './slider.component.html',
  styleUrl: './slider.component.scss'
})
export class SliderComponent {
  constructor(private router: Router) {

  }
  @Input() genres!: Genre[] | undefined;
  @Input() isLoading: boolean = false;

  carouselOptionsMultiItem: OwlOptions = {
    loop: true,
    mouseDrag: false,
    touchDrag: true,
    pullDrag: true,
    dots: false,
    autoplayHoverPause: true,
    nav: true,
    navSpeed: 700,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      600: {
        items: 3
      },
      740: {
        items: 4
      },
      1200: {
        items: 5
      }
    }
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
