<?php

namespace App\Http\Requests\Condominium;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

class editCondominiumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1]); // superAdmin
    }

    protected function failedAuthorization()
    {
        throw new UnauthorizedException('No tienes permiso para editar gastos.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sizes' => 'required|string|min:0',
            'porcent' => 'required|numeric|min:0|max:100',
            'tower' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value != 0 && !\DB::table('condominium')->where('id', $value)->exists()) {
                        $fail('El ID del condominio padre debe ser válido o 0.');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'sizes.required' => 'El tamaño es obligatorio.',
            'sizes.string' => 'El tamaño debe ser texto.',
            'sizes.min' => 'El tamaño no puede ser negativo.',

            'porcent.required' => 'El porcentaje es obligatorio.',
            'porcent.numeric' => 'El porcentaje debe ser un número.',
            'porcent.min' => 'El porcentaje no puede ser menor a 0.',
            'porcent.max' => 'El porcentaje no puede superar 100.',

            'tower.integer' => 'La torre no cumple con las caracteristicas.',
        ];
    }
}
