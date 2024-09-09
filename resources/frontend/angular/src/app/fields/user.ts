import { FormField } from "../models/form";

export class UserFields {
  user_fields: FormField[] = [
    {
      name: "nome",
      class: "col-md-6",
      type: "text",
      path: "person.nome",
      value: "",
      label: "Nome",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il nome è richiesto"
        }
      ]
    },
    {
      name: 'cognome',
      class: "col-md-6",
      type: "text",
      path: "person.cognome",
      value: "",
      label: "Cognome",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il cognome è richiesto"
        }
      ]
    },
    {
      name: 'data_nascita',
      class: "col-md-6",
      type: "date",
      path: "person.data_nascita",
      value: "",
      label: "Data di nascita",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La data di nascita è richiesta"
        }
      ]
    },
    {
      name: 'sesso',
      class: "col-md-6",
      type: "select",
      path: "person.sesso",
      options: [
        {
          label: "M",
          value: "M"
        },
        {
          label: "F",
          value: "F"
        }
      ],
      value: "",
      label: "Sesso ",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il sesso è richiesto"
        }
      ]
    },
    {
      name: 'cf',
      class: "col-md-6",
      type: "text",
      path: "person.cf",
      value: "",
      label: "Codice fiscale",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il codice fiscale è richiesto"
        },
        {
          name: "pattern",
          validator: "pattern",
          value: "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$",
          message: "Formato codice fiscale non valido"
        }
      ]
    },
    {
      name: 'user',
      class: "col-md-6",
      type: "email",
      path: "user",
      value: "",
      label: "E-mail",
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
      name: 'role_id',
      type: "radio",
      path: "role_id",
      optionData: {
        slug: 'roles',
        slug_label: 'nome',
        slug_value: 'id'
      },
      value: "",
      label: "Ruolo",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il Ruolo è richiesto"
        }
      ]
    },
    {
      name: 'state_id',
      type: "radio",
      path: "state_id",
      optionData: {
        slug: 'states',
        slug_label: 'nome',
        slug_value: 'id'
      },
      value: "",
      label: "Stato",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Lo stato è richiesto"
        }
      ]
    },
    {
      name: 'password',
      class: "col-md-6",
      type: "password",
      showPassword: false,
      value: "",
      label: "Password",
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
    {
      name: 'password2',
      class: "col-md-6",
      type: "password",
      showPassword: false,
      value: "",
      label: "Reinserisci la Password",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La conferma della password è richiesta"
        },
        {
          name: "confirmPassword",
          validator: "confirmPassword",
          message: "Le due password devono coincidere!",
          value: 'password'
        }
      ]
    },
    {
      name: 'contacts',
      class: "col-md-12",
      type: "group",
      value: "",
      label: "Contatti",
      group: {
        title: "Contatti",
        title_singolar: "Contatto",
        label_insert: "Inserisci contatto",
        label_delete: "Elimina contatto",
        values: [],
        path: 'person.contacts',
        fields: [
          {
            name: 'id',
            class: "",
            type: "hidden",
            path: "id",
            value: "",
            label: ""
          },
          {
            name: 'contact_type_id',
            class: "col-md-6",
            type: "select",
            path: "contact_type_id",
            optionData: {
              slug: 'contactTypes',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Tipo Contatto",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il tipo contatto è richiesto"
              }
            ]
          },
          {
            name: 'contatto',
            class: "col-md-6",
            type: "text",
            path: "contatto",
            value: "",
            label: "Contatto",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il contatto è richiesto"
              }
            ]
          }
        ]
      }
    },
    {
      name: 'addresses',
      class: "col-md-12",
      type: "group",
      value: "",
      label: "Indirizzi",
      group: {
        title: "Indirizzi",
        title_singolar: "Indirizzo",
        label_insert: "Inserisci indirizzo",
        label_delete: "Elimina indirizzo",
        values: [],
        path: 'person.addresses',
        fields: [
          {
            name: 'id',
            class: "",
            type: "hidden",
            path: "id",
            value: "",
            label: ""
          },
          {
            name: 'address_type_id',
            class: "col-md-6",
            type: "select",
            path: "address_type_id",
            optionData: {
              slug: 'addressTypes',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Tipo Indirizzo",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il tipo indirizzo è richiesto"
              }
            ]
          },
          {
            name: 'indirizzo',
            class: "col-md-6",
            type: "text",
            path: "indirizzo",
            value: "",
            label: "Indirizzo",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "L'indirizzo è richiesto"
              }
            ]
          },
          {
            name: 'civico',
            class: "col-md-3",
            type: "text",
            path: "civico",
            value: "",
            label: "N. Civico",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il N. Civico è richiesto"
              }
            ]
          },
          {
            name: 'municipality_id',
            class: "col-md-3",
            type: "select",
            path: "municipality_id",
            optionData: {
              slug: 'municipalities',
              slug_label: 'comune',
              slug_value: 'id'
            },
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
            name: 'CAP',
            class: "col-md-3",
            type: "text",
            path: "CAP",
            value: "",
            label: "CAP",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il CAP è richiesto"
              }
            ]
          },
          {
            name: 'nation_id',
            class: "col-md-3",
            type: "select",
            path: "nation_id",
            optionData: {
              slug: 'nations',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Nazione",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "La nazione è richiesta"
              }
            ]
          }
        ]
      }
    }
  ];

  //LIMITATO
  user_limited_fields: FormField[] = [
    {
      name: 'role_id',
      class: "",
      type: "hidden",
      path: "role_id",
      value: "",
      label: ""
    },
    {
      name: 'state_id',
      class: "",
      type: "hidden",
      path: "state_id",
      value: "",
      label: ""
    },
    {
      name: "nome",
      class: "col-md-6",
      type: "text",
      path: "person.nome",
      value: "",
      label: "Nome",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il nome è richiesto"
        }
      ]
    },
    {
      name: 'cognome',
      class: "col-md-6",
      type: "text",
      path: "person.cognome",
      value: "",
      label: "Cognome",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il cognome è richiesto"
        }
      ]
    },
    {
      name: 'data_nascita',
      class: "col-md-6",
      type: "date",
      path: "person.data_nascita",
      value: "",
      label: "Data di nascita",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La data di nascita è richiesta"
        }
      ]
    },
    {
      name: 'sesso',
      class: "col-md-6",
      type: "select",
      path: "person.sesso",
      options: [
        {
          label: "M",
          value: "M"
        },
        {
          label: "F",
          value: "F"
        }
      ],
      value: "",
      label: "Sesso ",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il sesso è richiesto"
        }
      ]
    },
    {
      name: 'cf',
      class: "col-md-6",
      type: "text",
      path: "person.cf",
      value: "",
      label: "Codice fiscale",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il codice fiscale è richiesto"
        },
        {
          name: "pattern",
          validator: "pattern",
          value: "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$",
          message: "Formato codice fiscale non valido"
        }
      ]
    },
    {
      name: 'user',
      class: "col-md-6",
      type: "email",
      path: "user",
      value: "",
      label: "E-mail",
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
      class: "col-md-6",
      type: "password",
      showPassword: false,
      value: "",
      label: "Password",
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
    {
      name: 'password2',
      class: "col-md-6",
      type: "password",
      showPassword: false,
      value: "",
      label: "Reinserisci la Password",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La conferma della password è richiesta"
        },
        {
          name: "confirmPassword",
          validator: "confirmPassword",
          message: "Le due password devono coincidere!",
          value: 'password'
        }
      ]
    },
    {
      name: 'contacts',
      class: "col-md-12",
      type: "group",
      value: "",
      label: "Contatti",
      group: {
        title: "Contatti",
        title_singolar: "Contatto",
        label_insert: "Inserisci contatto",
        label_delete: "Elimina contatto",
        values: [],
        path: 'person.contacts',
        fields: [
          {
            name: 'id',
            class: "",
            type: "hidden",
            path: "id",
            value: "",
            label: ""
          },
          {
            name: 'contact_type_id',
            class: "col-md-6",
            type: "select",
            path: "contact_type_id",
            optionData: {
              slug: 'contactTypes',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Tipo Contatto",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il tipo contatto è richiesto"
              }
            ]
          },
          {
            name: 'contatto',
            class: "col-md-6",
            type: "text",
            path: "contatto",
            value: "",
            label: "Contatto",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il contatto è richiesto"
              }
            ]
          }
        ]
      }
    },
    {
      name: 'addresses',
      class: "col-md-12",
      type: "group",
      value: "",
      label: "Indirizzi",
      group: {
        title: "Indirizzi",
        title_singolar: "Indirizzo",
        label_insert: "Inserisci indirizzo",
        label_delete: "Elimina indirizzo",
        values: [],
        path: 'person.addresses',
        fields: [
          {
            name: 'id',
            class: "",
            type: "hidden",
            path: "id",
            value: "",
            label: ""
          },
          {
            name: 'address_type_id',
            class: "col-md-6",
            type: "select",
            path: "address_type_id",
            optionData: {
              slug: 'addressTypes',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Tipo Indirizzo",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il tipo indirizzo è richiesto"
              }
            ]
          },
          {
            name: 'indirizzo',
            class: "col-md-6",
            type: "text",
            path: "indirizzo",
            value: "",
            label: "Indirizzo",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "L'indirizzo è richiesto"
              }
            ]
          },
          {
            name: 'civico',
            class: "col-md-3",
            type: "text",
            path: "civico",
            value: "",
            label: "N. Civico",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il N. Civico è richiesto"
              }
            ]
          },
          {
            name: 'municipality_id',
            class: "col-md-3",
            type: "select",
            path: "municipality_id",
            optionData: {
              slug: 'municipalities',
              slug_label: 'comune',
              slug_value: 'id'
            },
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
            name: 'CAP',
            class: "col-md-3",
            type: "text",
            path: "CAP",
            value: "",
            label: "CAP",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il CAP è richiesto"
              }
            ]
          },
          {
            name: 'nation_id',
            class: "col-md-3",
            type: "select",
            path: "nation_id",
            optionData: {
              slug: 'nations',
              slug_label: 'nome',
              slug_value: 'id'
            },
            value: "",
            label: "Nazione",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "La nazione è richiesta"
              }
            ]
          }
        ]
      }
    }
  ];
}
