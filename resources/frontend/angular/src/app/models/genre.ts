import { Film } from "./film";
import { Serie } from "./serie";

export interface Genre {
  id: number,
  nome: string,
  movies: (Film | Serie)[]
}
