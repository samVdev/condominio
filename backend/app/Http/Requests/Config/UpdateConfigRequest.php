<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2]);
    }

    public function rules(): array
    {
        return [
            'titu'    => 'required|string|max:50',
            'cedu'    => 'required|string|size:8',
            'cuenta' => 'required|string|size:20',
            'cel' => ['required', 'regex:/^\+?[1-9][0-9]{7,14}$/']
        ];
    }
    
    public function messages(): array
    {
        return [
            'titu.required'    => 'El nombre del titular es obligatorio.',
            'titu.string'      => 'El nombre del titular debe ser una cadena de texto.',
            'titu.max'         => 'El nombre del titular no puede exceder los 50 caracteres.',
    
            'cedu.required'    => 'La cédula es obligatoria.',
            'cedu.string'      => 'La cédula debe ser una cadena de texto.',
            'cedu.size'        => 'La cédula debe tener exactamente 8 caracteres.',
    
            'cuenta.required' => 'El número de cuenta es obligatorio.',
            'cuenta.string'   => 'El número de cuenta debe ser una cadena de texto.',
            'cuenta.size'     => 'El número de cuenta debe tener exactamente 20 caracteres.',

            "cel.required" => "El número de teléfono es obligatorio.",
            'cel.regex' => 'El número de teléfono no es válido. Por favor ingrese un número entre 8 y 15 dígitos.'
        ];
    }
    
}
