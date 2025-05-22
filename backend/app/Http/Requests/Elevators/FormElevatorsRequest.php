<?php

namespace App\Http\Requests\Elevators;

use Illuminate\Foundation\Http\FormRequest;

class FormElevatorsRequest extends FormRequest
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
            'number' => 'required|numeric|min:0|max:100',
            'tower' => ['integer','exists:condominium,id']
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'El número del elevador es obligatorio.',
            'number.numeric' => 'El número del elevador debe ser un número.',
            'number.min' => 'El número del elevador no puede ser menor a 0.',
            'number.max' => 'El número del elevador no puede superar 100.',

            'tower.integer' => 'La torre no cumple con las caracteristicas.',
            'tower.exists' => 'La torre no existe.',
        ];
    }
}
