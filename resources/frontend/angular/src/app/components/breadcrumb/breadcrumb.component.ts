import { CommonModule } from '@angular/common';
import { Component, Input } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { ApiService } from '../../services/api/api.service';

@Component({
  selector: 'app-breadcrumb',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './breadcrumb.component.html',
  styleUrl: './breadcrumb.component.scss'
})
export class BreadcrumbComponent {
  constructor(private route: ActivatedRoute, private apiService: ApiService) { }
  paths: string[] = [];
  @Input() titolo: string[] | null = null;

  ngOnInit() {
    if (this.titolo) {
      this.paths = this.titolo;
    }
    else {
      this.route.url.subscribe((paths) => {
        if (this.route.params) {
          this.route.params.subscribe(params => {
            var id_genre = params['id'];
            for (var i = 0; i < paths.length; i++) {
              if (paths[i] != id_genre) {
                this.paths.push(paths[i].toString());
              }
              else {
                this.apiService.getGenre(id_genre).subscribe((genre) => {
                  this.paths.push(genre.nome);
                });
              }
            }
          });
        }
        else {
          paths.map((path) => {
            this.paths.push(path.toString());
          });
        }
      });
    }
  }

}
