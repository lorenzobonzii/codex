import { CommonModule } from '@angular/common';
import { Component, Input, TemplateRef } from '@angular/core';
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ApiService } from '../../services/api/api.service';
import { FormField } from '../../models/form';
import { ToastService } from '../../services/toast/toast.service';
import { ActivatedRoute, Router } from '@angular/router';
import { last } from 'rxjs';

@Component({
  selector: 'app-delete',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './delete.component.html',
  styleUrl: './delete.component.scss'
})
export class DeleteComponent {
  constructor(private router: Router, private route: ActivatedRoute, private apiService: ApiService, private toastService: ToastService, private modalService: NgbModal) { }
  @Input() slug!: string;
  @Input() id!: number;
  @Input() fields!: FormField[] | null;
  path!: any;

  open(content: TemplateRef<any>) {
    this.path = this.route.routeConfig?.path?.split('/');
    if (this.path.slice(-1)[0].toString().includes(':')) {
      this.path.pop();
    }
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then(
      (result) => {
        this.apiService.delete(this.slug, this.id).subscribe(() => {
          this.apiService.reload(this.slug, true).subscribe(() => {
            this.router.navigate(['/']).then(() => { this.router.navigate(this.path); })
            this.toastService.showSuccessToast('CANCELLAZIONE', 'RISORSA ELIMINATA CORRETTAMENTE!');
          });
        });
      },
    );
  }
}
