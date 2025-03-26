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
            'month' => 'required|numeric|min:1|max:12',
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
            'month.required' => 'El mes es obligatorio.',
            'porcent.numeric' => 'El mes debe ser un valor numérico.',
            'month.min' => 'El mes debe de ser valido.',
            'month.max' => 'El mes debe de ser valido.',

            'porcent.required' => 'El porcentaje es obligatorio.',
            'porcent.numeric' => 'El porcentaje debe ser un valor numérico.',
            'porcent.min' => 'El porcentaje debe ser mayor o igual a 0.',
            'porcent.max' => 'El porcentaje no puede ser mayor a 10.',
        ];
    }
}
