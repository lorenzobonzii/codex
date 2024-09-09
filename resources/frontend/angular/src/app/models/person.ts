import { Address } from "./address";
import { Contact } from "./contact";

export interface Person {
  id: number,
  nome: string,
  cognome: string,
  data_nascita: string,
  sesso: string,
  cf: string,
  addresses: Address[],
  contacts: Contact[]
}
