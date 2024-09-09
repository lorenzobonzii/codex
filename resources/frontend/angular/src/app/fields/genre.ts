import { FormField } from "../models/form";

export class GenreFields {
  genre_fields: FormField[] = [
    {
      name: "nome",
      type: "text",
      path: "nome",
      value: "",
      label: "Nome",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il nome è richiesto"
        }
      ]
    }
  ];
}
