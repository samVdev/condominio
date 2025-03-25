<?php

namespace App\Http\Requests\Expenses;

use Illuminate\Foundation\Http\FormRequest;

class FormExpensesRequest extends FormRequest
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
            'mount_bs' => 'required|numeric|min:100',
            'porcent' => 'numeric|min:0',
            'id' => 'nullable|string',
            'service' => 'required|integer|exists:services,id',
            'tower' => 'required|integer|exists:condominium,id',
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
            'mount_bs.required' => 'El Gasto es obligatorio.',
            'mount_bs.numeric' => 'El Gasto debe ser un número.',
            'mount_bs.min' => 'El Gasto debe ser minimo 100 bs.',

            'porcent.numeric' => 'El porcentaje debe ser un número.',
            'porcent.min' => 'El porcentaje debe ser mayor o igual a 0.',

            'service.required' => 'El Servicio es obligatorio.',
            'service.integer' => 'El Servicio debe ser un número entero.',

            'tower.required' => 'La torre es obligatorio.',
            'tower.integer' => 'La torre debe ser un número entero.',

            'file.image' => 'El archivo debe ser una imagen.',
            'file.mimes' => 'Solo se permiten imágenes en formato JPEG, PNG, JPG o GIF.',
            'file.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
