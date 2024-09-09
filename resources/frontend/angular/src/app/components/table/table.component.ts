
import { CommonModule } from '@angular/common';
import { NgbModal, NgbModalModule } from '@ng-bootstrap/ng-bootstrap';
import { Component, Input, TemplateRef, ViewChild } from '@angular/core';
import { ApiService } from '../../services/api/api.service';
import { DeleteComponent } from '../delete/delete.component';
import { UpdateComponent } from '../update/update.component';
import { FormField } from '../../models/form';
import { InsertComponent } from '../insert/insert.component';
import { DataTablesModule } from "angular-datatables";
import { Config } from 'datatables.net';
import { HttpClient } from '@angular/common/http';
import { ActionsComponent } from '../actions/actions.component';
// @ts-ignore
import language from 'datatables.net-plugins/i18n/it-IT.mjs';
import { SpinnerComponent } from '../spinner/spinner.component';


@Component({
  selector: 'app-table',
  standalone: true,
  imports: [CommonModule, NgbModalModule, UpdateComponent, DeleteComponent, InsertComponent, DataTablesModule, ActionsComponent, SpinnerComponent],
  templateUrl: './table.component.html',
  styleUrl: './table.component.scss'
})
export class TableComponent {
  constructor(private http: HttpClient, private apiService: ApiService) { }

  dtOptions!: Config;
  @Input() campi!: any[];
  @Input() slug!: string;
  @Input() fields!: FormField[];
  columns: any[] = [];
  @ViewChild('actions') actions!: TemplateRef<ActionsComponent>;

  ngOnInit(): void {
    setTimeout(() => {

      this.campi.push({
        data: null,
        title: "Azioni",
        searchable: false,
        sortable: false,
        filterable: false,
        defaultContent: '',
        ngTemplateRef: {
          ref: this.actions
        }
      });
      this.http.get<{ data: any[] }>(this.apiService.creaUrl([this.slug])).subscribe(result => {
        this.dtOptions = {
          language,
          data: result.data,
          columns: this.campi
        }
      })
    }, 1500);
  }
}
