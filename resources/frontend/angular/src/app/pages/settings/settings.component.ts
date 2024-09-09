import { Component, ViewEncapsulation } from '@angular/core';
import { ApiService } from '../../services/api/api.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { TableComponent } from '../../components/table/table.component';
import { FormField } from '../../models/form';
import { Form } from '@angular/forms';
import { InsertComponent } from '../../components/insert/insert.component';
import { UserFields } from '../../fields/user';
import { NationFields } from '../../fields/nation';
import { OptionFields } from '../../fields/option';
import { MunicipalityFields } from '../../fields/municipality';
import { GenreFields } from '../../fields/genre';

@Component({
  selector: 'app-settings',
  standalone: true,
  imports: [CommonModule, RouterLink, TableComponent],
  encapsulation: ViewEncapsulation.None,
  templateUrl: './settings.component.html',
  styleUrl: './settings.component.scss'
})
export class SettingsComponent {
  constructor(private apiService: ApiService) { }

  //OPTIONS
  option_campi: any[] = [{ title: 'ID', data: 'id' }, { title: 'Chiave', data: 'chiave' }, { title: 'Valore', data: 'valore' }];
  option_fields: FormField[] = new OptionFields().option_fields;

  //USERS
  user_campi: any[] = [{ title: 'ID', data: 'id' }, { title: 'Nome', data: 'person.nome' }, { title: 'Cognome', data: 'person.cognome' }, { title: 'Codice fiscale', data: 'person.cf' }, { title: 'Ruolo', data: 'role.nome' }, { title: 'Stato', data: 'state.nome' }, { title: 'Scadenza sfida', data: 'scadenza_sfida' }, { title: 'Username', data: 'user' },];
  user_fields: FormField[] = new UserFields().user_fields;

  //GENRES
  genre_campi: any[] = [{ title: 'ID', data: 'id' }, { title: 'Nome', data: 'nome' }];
  genre_fields: FormField[] = new GenreFields().genre_fields;

  //NATIONS
  nation_campi: any[] = [{ title: 'ID', data: 'id' }, { title: 'Nome', data: 'nome' }, { title: 'Continente', data: 'continente' }, { title: 'ISO', data: 'iso' }, { title: 'ISO3', data: 'iso3' }, { title: 'Prefisso telefonico', data: 'prefisso_telefonico' }];
  nation_fields: FormField[] = new NationFields().nation_fields;

  //MUNICIPALITIES
  municipality_campi: any[] = [{ title: 'ID', data: 'id' }, { title: 'Comune', data: 'comune' }, { title: 'Regione', data: 'regione' }, { title: 'Provincia', data: 'provincia' }, { title: 'Sigla', data: 'sigla' }, { title: 'CAP', data: 'cap' }];
  municipality_fields: FormField[] = new MunicipalityFields().municipality_fields;

  ngOnInit(): void {
  }
}
