import { FormField } from "../models/form";

export class NationFields {
  nation_fields: FormField[] = [
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
          message: "Il nome è richiesta"
        }
      ]
    },
    {
      name: 'continente',
      type: "text",
      path: "continente",
      value: "",
      label: "Continente",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il continente è richiesto"
        }
      ]
    },
    {
      name: 'iso',
      type: "text",
      path: "iso",
      value: "",
      label: "ISO",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "ISO richiesto"
        }
      ]
    },
    {
      name: 'iso3',
      type: "text",
      path: "iso3",
      value: "",
      label: "ISO3",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "ISO3 richiesto"
        }
      ]
    },
    {
      name: 'prefisso_telefonico',
      type: "text",
      path: "prefisso_telefonico",
      value: "",
      label: "Prefisso telefonico",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il prefisso telefonico è richiesto"
        }
      ]
    }
  ];
}
