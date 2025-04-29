<?php

namespace App\Http\Requests\TypeEarnings;

use Illuminate\Foundation\Http\FormRequest;

class TypeEarningEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2]);
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del servicio es obligatorio.',
            'name.string' => 'El nombre del servicio debe ser un texto.',
            'name.max' => 'El nombre del servicio no puede tener más de 255 caracteres.',

            'id.exists' => 'El servicio no existe.',
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_elevator' => ['boolean'],
            'id' => ['exists:type_earnings,id']
        ];
    }
}
