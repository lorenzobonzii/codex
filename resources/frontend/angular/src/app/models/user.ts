import { Person } from "./person";
import { Role } from "./role";
import { State } from "./state";

export interface User {
  id: number,
  role_id: number,
  role: Role,
  state_id: number,
  state: State,
  person_id: number,
  person: Person,
  user: string,
  scadenza_sfida: string
}
