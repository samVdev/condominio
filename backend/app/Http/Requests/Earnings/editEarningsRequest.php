<?php

namespace App\Http\Requests\Earnings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

class editEarningsRequest extends FormRequest
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
            'porcent' => 'numeric|min:0',
            'id' => 'nullable|string',
            'type' => 'required|integer|exists:type_earnings,id',
            'tower' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value != 0 && !\DB::table('condominium')->where('id', $value)->exists()) {
                        $fail('El valor de la torre debe ser un ID válido o 0.');
                    }
                },
            ],
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'mount_dollars.required' => 'El ingreso es obligatorio.',
            'mount_dollars.numeric' => 'El ingreso debe ser un número.',
            'mount_dollars.min' => 'El ingreso debe ser minimo 1$.',

            'porcent.numeric' => 'El porcentaje debe ser un número.',
            'porcent.min' => 'El porcentaje debe ser mayor o igual a 0.',

            'type.required' => 'El Servicio es obligatorio.',
            'type.integer' => 'El Servicio debe ser un número entero.',

            'tower.required' => 'La torre es obligatorio.',
            'tower.integer' => 'La torre debe ser un número entero.',

            'file.image' => 'El archivo debe ser una imagen.',
            'file.mimes' => 'Solo se permiten imágenes en formato JPEG, PNG, JPG o GIF.',
            'file.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
