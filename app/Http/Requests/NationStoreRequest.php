<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NationStoreRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'continente' => 'required|string|max:255',
            'iso' => 'required|string|max:2',
            'iso3' => 'required|string|max:3',
            'prefisso_telefonico' => 'required|string|max:255',
        ];
    }
}
