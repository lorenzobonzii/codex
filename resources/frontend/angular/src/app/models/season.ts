import { Episode } from "./episode";
import { Serie } from "./serie";

export interface Season {
  id: number,
  titolo: string,
  ordine: number,
  anno: number,
  trama: string,
  copertina: string,
  url_copertina: string,
  serie: Serie,
  episodes: Episode[]
}
