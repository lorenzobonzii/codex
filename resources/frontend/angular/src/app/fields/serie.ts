import { FormField } from "../models/form";

export class SerieFields {
  serie_fields: FormField[] = [
    {
      name: "titolo",
      class: "col-md-6",
      type: "text",
      path: "titolo",
      value: "",
      label: "Titolo",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Il titolo è richiesto"
        }
      ]
    },
    {
      name: 'anno',
      class: "col-md-3",
      type: "number",
      path: "anno",
      value: "",
      label: "Anno",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "L'anno è richiesto"
        }
      ]
    },
    {
      name: 'lingua',
      class: "col-md-3",
      type: "text",
      path: "lingua",
      value: "",
      label: "Lingua",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La lingua è richiesta"
        }
      ]
    },
    {
      name: 'attori',
      class: "col-md-6",
      type: "text",
      path: "attori",
      value: "",
      label: "Attori",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "Gli attori sono richiesti"
        }
      ]
    },
    {
      name: 'regia',
      class: "col-md-6",
      type: "text",
      path: "regia",
      value: "",
      label: "Regia",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "La regia è richiesta"
        }
      ]
    },
    {
      name: 'copertina_v',
      class: "col-md-12",
      type: "image",
      path: "copertina_v",
      value: "",
      label: "Copertina verticale",
      image: {
        aspectRatio: 2 / 3,
        url: "",
        urlPath: "url_copertina_v"
      }
    },
    {
      name: 'copertina_o',
      class: "col-md-12",
      type: "image",
      path: "copertina_o",
      value: "",
      label: "Copertina orizzontale",
      image: {
        aspectRatio: 500 / 281,
        url: "",
        urlPath: "url_copertina_o"
      }
    },
    {
      name: 'genres',
      class: "col-md-6",
      type: "select-multiplo",
      path: "genres_ids",
      optionData: {
        slug: 'genres',
        slug_label: 'nome',
        slug_value: 'id'
      },
      values: [],
      label: "Generi",
      validations: [
        {
          name: "required",
          validator: "required",
          message: "I generi sono richiesti"
        }
      ]
    },
    {
      name: 'anteprima',
      class: "col-md-3",
      type: "text",
      path: "anteprima",
      value: "",
      label: "Anteprima"
    },
    {
      name: 'nation_id',
      class: "col-md-3",
      type: "select",
      path: "nation.id",
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
    },
    {
      name: 'trama',
      class: "col-md-12",
      type: "textarea",
      path: "trama",
      value: "",
      label: "Trama"
    },
    {
      name: 'seasons',
      class: "col-md-12",
      type: "group",
      value: "",
      label: "Stagioni",
      group: {
        title: "Stagioni",
        title_singolar: "Stagione",
        label_insert: "Inserisci stagione",
        label_delete: "Elimina stagione",
        values: [],
        path: 'seasons',
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
            name: 'titolo',
            class: "col-md-6",
            type: "text",
            path: "titolo",
            value: "",
            label: "Titolo",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "Il titolo è richiesto"
              }
            ]
          },
          {
            name: 'ordine',
            class: "col-md-3",
            type: "number",
            path: "ordine",
            value: "",
            label: "Ordine",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "L'ordine è richiesto"
              }
            ]
          },
          {
            name: 'anno',
            class: "col-md-3",
            type: "number",
            path: "anno",
            value: "",
            label: "Anno",
            validations: [
              {
                name: "required",
                validator: "required",
                message: "L'anno è richiesto"
              }
            ]
          },
          {
            name: 'trama',
            class: "col-md-12",
            type: "textarea",
            path: "trama",
            value: "",
            label: "Trama"
          },
          {
            name: 'copertina',
            class: "col-md-12",
            type: "image",
            path: "copertina",
            value: "",
            label: "Copertina orizzontale",
            image: {
              aspectRatio: 500 / 281,
              url: "",
              urlPath: "url_copertina"
            }
          },
          {
            name: 'episodes',
            class: "col-md-12",
            type: "group",
            value: "",
            label: "Episodi",
            group: {
              title: "Episodi",
              title_singolar: "Episodio",
              label_insert: "Inserisci episodio",
              label_delete: "Elimina episodio",
              values: [],
              path: 'episodes',
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
                  name: 'titolo',
                  class: "col-md-6",
                  type: "text",
                  path: "titolo",
                  value: "",
                  label: "Titolo",
                  validations: [
                    {
                      name: "required",
                      validator: "required",
                      message: "Il titolo è richiesto"
                    }
                  ]
                },
                {
                  name: 'ordine',
                  class: "col-md-3",
                  type: "number",
                  path: "ordine",
                  value: "",
                  label: "Ordine",
                  validations: [
                    {
                      name: "required",
                      validator: "required",
                      message: "L'ordine è richiesto"
                    }
                  ]
                },
                {
                  name: 'durata',
                  class: "col-md-3",
                  type: "number",
                  path: "durata",
                  value: "",
                  label: "Durata",
                  validations: [
                    {
                      name: "required",
                      validator: "required",
                      message: "La durata è richiesta"
                    }
                  ]
                },
                {
                  name: 'descrizione',
                  class: "col-md-12",
                  type: "textarea",
                  path: "descrizione",
                  value: "",
                  label: "Descrizione"
                },
                {
                  name: 'copertina',
                  class: "col-md-12",
                  type: "image",
                  path: "copertina",
                  value: "",
                  label: "Copertina orizzontale",
                  image: {
                    aspectRatio: 500 / 281,
                    url: "",
                    urlPath: "url_copertina"
                  }
                },
              ]
            }
          }
        ]
      }
    }
  ];
}
