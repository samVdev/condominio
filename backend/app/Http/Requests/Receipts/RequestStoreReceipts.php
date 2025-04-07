<?php

namespace App\Http\Requests\Receipts;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreReceipts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2, 3, 4]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string|exists:factures,code',
            'cedula' => 'required|digits:8',
            'ref' => 'required|string|size:6',
            'dollar_bcv' => 'required|numeric|min:0',
            'totalDol' => 'required|numeric|min:0',
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
            'id.required' => 'La factura es obligatoria.',
            'id.integer' => 'La factura debe ser un número entero.',
            'id.exists' => 'La factura seleccionada no existe.',

            'cedula.required' => 'La cedula es obligatoria.',
            'cedula.digits' => 'La cedula tiene que ser de 8 digitos.',

            'ref.required' => 'La referencia es obligatoria.',
            'ref.size' => 'La referencia tiene que tener 6 digitos.',

            'dollar_bcv.required' => 'El total en bs es obligatorio.',
            'dollar_bcv.numeric' => 'El total en bs es obligatorio.',
            
            'totalDol.required' => 'El total en bs es obligatorio.',
            'totalDol.numeric' => 'El total en bs es obligatorio.',
        ];
    }
}
