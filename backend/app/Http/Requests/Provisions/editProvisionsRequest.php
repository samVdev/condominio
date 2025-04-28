<?php

namespace App\Http\Requests\Provisions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

class editProvisionsRequest extends FormRequest
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
            'mount_dollars' => 'required|numeric|min:1',
            'id' => 'nullable|string',
            'service' => 'required|integer|exists:services,id',
            'tower' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value != 0 && !\DB::table('condominium')->where('id', $value)->exists()) {
                        $fail('El valor de la torre debe ser un ID válido o 0.');
                    }
                },
            ],
            'month' => 'required|numeric|min:1|max:12',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'mount_dollars.required' => 'La provisión es obligatorio.',
            'mount_dollars.numeric' => 'La provisión debe ser un número.',
            'mount_dollars.min' => 'La provisión debe ser minimo 1$.',

            'service.required' => 'El Servicio es obligatorio.',
            'service.integer' => 'El Servicio debe ser un número entero.',

            'tower.required' => 'La torre es obligatorio.',
            'tower.integer' => 'La torre debe ser un número entero.',

            'month.required' => 'El mes es obligatorio.',
            'porcent.numeric' => 'El mes debe ser un valor numérico.',
            'month.min' => 'El mes debe de ser valido.',
            'month.max' => 'El mes debe de ser valido.',
        ];
    }
}
