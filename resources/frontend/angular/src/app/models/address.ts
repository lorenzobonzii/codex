import { AddressType } from "./address-type";
import { Municipality } from "./municipality";
import { Nation } from "./nation";

export interface Address {
  id: number,
  person_id: number,
  address_type_id: number,
  address_type: AddressType,
  indirizzo: string,
  civico: number,
  municipality_id: number,
  municipality: Municipality,
  CAP: number,
  nation_id: number,
  nation: Nation,
}
