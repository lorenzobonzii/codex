import { FormField } from "../models/form";

export class LoginFields {
  login_fields: FormField[] = [
    {
      name: 'user',
      type: "email",
      value: '',
      placeholder: "E-mail",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "L'email è richiesta"
        },
        {
          name: "email",
          validator: "email",
          message: "Formato email non valido"
        }
      ]
    },
    {
      name: 'password',
      type: "password",
      showPassword: false,
      value: "",
      placeholder: "Password",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La password è richiesta"
        },
        {
          name: "minlength",
          validator: "minLength",
          value: "8",
          message: "La password deve contenere almeno 8 caratteri"
        }
      ]
    },
  ];
}
