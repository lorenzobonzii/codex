<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerieStoreRequest extends FormRequest
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
            'regia' => 'required|string|max:255',
            'anno' => 'required|integer',
            'lingua' => 'required|string|max:255',
            'attori' => 'required|string|max:255',
            'anteprima' => 'max:255',
            'trama' => 'max:10000',
            'nation_id' => 'required|integer|exists:nations,id',
            'genres' => 'array|min:1',
            'genres.*' => 'integer',
            'seasons' => 'array|min:1',
        ];
    }
}
