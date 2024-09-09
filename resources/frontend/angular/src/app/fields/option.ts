import { FormField } from "../models/form";

export class OptionFields {
  option_fields: FormField[] = [
    {
      name: "chiave",
      type: "text",
      path: "chiave",
      value: "",
      label: "Chiave",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La chiave è richiesta"
        }
      ]
    },
    {
      name: 'valore',
      type: "text",
      path: "valore",
      value: "",
      label: "Valore",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il valore è richiesto"
        }
      ]
    }
  ];
}
