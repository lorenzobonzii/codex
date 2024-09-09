<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'titolo' => 'required|string|max:255',
            'anno' => 'required|integer',
            'durata' => 'required|integer',
            'regia' => 'required|string|max:255',
            'attori' => 'required|string|max:255',
            'trama' => 'required|string|max:10000',
            'lingua' => 'required|string|max:255',
            'anteprima' => 'required|string|max:255',
            'nation_id' => 'required|integer|exists:nations,id',
            'genres' => 'array|min:1',
            'genres.*' => 'integer'
        ];
    }
}
