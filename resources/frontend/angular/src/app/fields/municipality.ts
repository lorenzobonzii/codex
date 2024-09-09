import { FormField } from "../models/form";

export class MunicipalityFields {
  municipality_fields: FormField[] = [
    {
      name: "comune",
      type: "text",
      path: "comune",
      value: "",
      label: "Comune",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il comune è richiesta"
        }
      ]
    },
    {
      name: 'regione',
      type: "text",
      path: "regione",
      value: "",
      label: "Regione",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La regione è richiesta"
        }
      ]
    },
    {
      name: 'provincia',
      type: "text",
      path: "provincia",
      value: "",
      label: "Provincia",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La provincia è richiesta"
        }
      ]
    },
    {
      name: 'sigla',
      type: "text",
      path: "sigla",
      value: "",
      label: "Sigla",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La sigla è richiesta"
        }
      ]
    },
    {
      name: 'codice_belfiore',
      type: "text",
      path: "codice_belfiore",
      value: "",
      label: "Codice belfiore",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il codice belfiore è richiesto"
        }
      ]
    },
    {
      name: 'cap',
      type: "text",
      path: "cap",
      value: "",
      label: "CAP",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il CAP è richiesto"
        }
      ]
    }
  ];
}
