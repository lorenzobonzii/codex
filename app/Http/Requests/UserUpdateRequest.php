<?php

namespace App\Http\Requests;

use App\Http\Helpers\AppHelpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Rules\CF;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends UserStoreRequest
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
            'role_id' => 'integer|exists:roles,id',
            'state_id' => 'integer|exists:states,id',
            'nome' => 'string|max:255',
            'cognome' => 'string|max:255',
            'sesso' => 'string|max:1',
            'data_nascita' => 'date',
            'cf' => [new CF],
            'indirizzo' => 'string|max:255',
            'nation_id' => 'integer|exists:nations,id',
            'municipality_id' => 'integer|exists:nations,id',
            'email' => 'string|max:255|email',
            'telefono' => 'string|max:255',
            'user' => [
                "string",
                "max:255",
                Rule::unique("App\Models\User", 'user')->whereNull('deleted_at')->ignore($this->route('user'))
            ],
            'password' => [
                'nullable',
                'string',
                'max:255',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            "contacts" => "array|min:1",
            "addresses" => "array|min:1",
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cf' => strtoupper($this->cf),
            'telefono' => str_replace(array(
                ' ',
                '.',
                '/',
                '\\',
                ':',
                '-',
                '*',
                '#',
                '(',
                ')'
            ), "", $this->telefono)
        ]);
    }

    public function validated($key = null, $default = null)
    {
        $request = $this->validator->validated();

        if ($this->filled('password')) {
            $request['password'] = hash('sha512', $this->password);
        } else {
            unset($request['password']);
        }
        $utente = Auth::getUser();
        if ($utente->role_id == 2 || $utente->role->nome == "Utente") {
            unset($request['role_id']);
            unset($request['state_id']);
        }
        return $request;
    }
}
