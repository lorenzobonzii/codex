import { ContactType } from "./contact-type";

export interface Contact {
  id: number,
  person_id: number,
  contact_type_id: number,
  contact_type: ContactType,
  contatto: string,
}
