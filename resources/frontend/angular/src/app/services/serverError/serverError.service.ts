import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ServerErrorService {
  errors: string[] = [];

  add(error: string) {
    this.errors.push(error);
  }

  clear() {
    this.errors = [];
  }

  get() {
    return this.errors;
  }
}
