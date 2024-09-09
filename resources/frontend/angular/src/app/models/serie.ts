import { Genre } from "./genre";
import { Season } from "./season";

export interface Serie {
  id: number,
  titolo: string,
  regia: string,
  attori: string,
  anno: number,
  durata: number,
  lingua: string,
  copertina_v: string,
  copertina_o: string,
  url_copertina_v: string,
  url_copertina_o: string,
  url_copertina_o_min: string,
  anteprima: string,
  trama: string,
  nation_id: number,
  genres: Genre[],
  seasons: Season[],
}
