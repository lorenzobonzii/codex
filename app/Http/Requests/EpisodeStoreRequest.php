<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeStoreRequest extends FormRequest
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
            'ordine' => 'required|integer',
            'durata' => 'required|integer',
            'copertina' => 'required|string|max:255',
            'descrizione' => 'required|string|max:10000',
            'season_id' => 'required|integer|exists:seasons,id',
        ];
    }
}
