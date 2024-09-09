<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'person_id' => 'required|integer|exists:people,id',
            'address_type_id' => 'required|integer|exists:address_types ,id',
            'indirizzo' => 'required|string|max:255',
            'civico' => 'required|string|max:10',
            'municipality_id' => 'required|integer|exists:municipalities,id',
            'CAP' => 'required|string|max:5',
            'nation_id' => 'required|integer|exists:nations,id',
        ];
    }
}
