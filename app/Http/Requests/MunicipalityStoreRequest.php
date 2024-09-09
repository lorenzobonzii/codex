<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comune' => 'required|string|max:255',
            'regione' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'sigla' => 'required|string|max:2',
            'codice_belfiore' => 'required|string|max:255',
            'cap' => 'required|string|max:255',
        ];
    }
}
