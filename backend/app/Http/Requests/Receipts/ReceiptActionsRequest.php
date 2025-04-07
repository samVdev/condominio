<?php

namespace App\Http\Requests\Receipts;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptActionsRequest extends FormRequest
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
    public function messages()
    {
        return [
            'action.required' => 'Debe aceptar o rechazar correctamente.',
            'action.boolean' => 'Debe aceptar o rechazar correctamente.',
            'id.required' => 'El recibo es obligatorio.',
            'id.exists' => 'El recibo especificado no existe en los recibos.'
        ];
    }

    public function rules()
    {
        return [
            'action' => ['required', 'boolean'],
            'id' => ['exists:receipts,id', 'required']
        ];
    }
}
