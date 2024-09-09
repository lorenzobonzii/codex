export interface Validation {
  name: string;
  validator: string;
  message: string;
  value?: string
};

export interface SelectOption {
  label: string;
  value: number | string | boolean;
}

export interface ModelData {
  name: string;
  validator: string;
  message: string;
  value?: string
};


export interface FormField {
  name: string,
  type: "text" | "number" | "date" | "radio" | "checkbox" | "select" | "select-multiplo" | "textarea" | "password" | "email" | "hidden" | "group" | "image",
  path?: string,
  value?: number | string | boolean | [],
  values?: number[],
  label?: string,
  placeholder?: string,
  showPassword?: boolean,
  validations?: Validation[],
  class?: string,
  options?: {
    label: string,
    value: number | string | boolean
  }[],
  optionData?: {
    slug: any,
    slug_label: string,
    slug_value: string
  }
  provideData?: {
    label: string,
    sourceValue: string,
    value: string
  }[],
  link?: string,
  group?: {
    title: string,
    title_singolar: string,
    label_insert: string,
    label_delete: string,
    fields: FormField[],
    path: string,
    values: FormField[][]
  },
  image?: {
    aspectRatio: number,
    url: string,
    urlPath: string
  }
}
