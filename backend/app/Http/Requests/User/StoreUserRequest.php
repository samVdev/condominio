<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array(auth()->user()->role->id, [1, 2]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

     public function messages()
{
    return [
        "name.required" => "El nombre es obligatorio.",
        "name.max" => "El nombre no debe exceder los 255 caracteres.",
        
        "email.required" => "El correo electrónico es obligatorio.",
        "email.email" => "El correo electrónico debe ser válido.",
        "email.max" => "El correo electrónico no debe exceder los 255 caracteres.",
        "email.unique" => "Este correo electrónico ya está registrado.",
        
        "password.required" => "La contraseña es obligatoria.",
        
        "role_id.required" => "El rol es obligatorio.",
        "role_id.exists" => "El rol seleccionado no es válido.",
        
        "phone.required" => "El número de teléfono es obligatorio.",
        "phone.regex" => "El número de teléfono no es válido.",

        "apt_id.required" => "El apartamento es obligatorio.",
        "apt_id.integer" => "El apartamento debe ser un número entero.",
        "apt_id.exists" => "El apartamento seleccionado no existe."
    ];
}

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'phone' => ['required', 'regex:/^(0412|0426|0424|0212|0416)\d{7}$/'],
            'apt_id' => ['required', 'integer', 'exists:condominium,id'],
            'suspend' => ['nullable', 'boolean']
        ];
    }
}
