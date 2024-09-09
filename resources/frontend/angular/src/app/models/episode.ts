import { Season } from "./season";

export interface Episode {
  id: number,
  titolo: string,
  ordine: number,
  durata: number,
  copertina: string,
  url_copertina: string,
  descrizione: string,
  season: Season
}
