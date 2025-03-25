<?php

namespace App\Http\Requests\Factures;

use Illuminate\Foundation\Http\FormRequest;

class FormFactureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tower' => 'required|integer|exists:condominium,id',
            'porcent' => 'required|numeric|min:0|max:10',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tower.required' => 'La torre es obligatoria.',
            'tower.integer' => 'La torre debe ser un número entero.',
            'tower.exists' => 'La torre seleccionada no existe.',

            'porcent.required' => 'El porcentaje es obligatorio.',
            'porcent.numeric' => 'El porcentaje debe ser un valor numérico.',
            'porcent.min' => 'El porcentaje debe ser mayor o igual a 0.',
            'porcent.max' => 'El porcentaje no puede ser mayor a 10.',
        ];
    }
}
