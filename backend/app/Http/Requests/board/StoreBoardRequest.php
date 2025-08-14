<?php

namespace App\Http\Requests\board;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;

class StoreBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2]); // superAdmin and admin
    }

    protected function failedAuthorization()
    {
        throw new UnauthorizedException('No tienes permiso para crear juntas de condominio.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after_or_equal:now',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la junta es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto válido.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            
            'descripcion.string' => 'La descripción debe ser texto válido.',
            
            'fecha.required' => 'La fecha de la junta es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'fecha.after_or_equal' => 'La junta debe programarse para una fecha futura.',
            
        ];
    }
}