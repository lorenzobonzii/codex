<?php

namespace App\Http\Requests;

use App\Http\Helpers\AppHelpers;
use Illuminate\Foundation\Http\FormRequest;

class MunicipalityUpdateRequest extends MunicipalityStoreRequest
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
        $rules = parent::rules();
        return AppHelpers::HelperNewRules($rules);
    }
}
