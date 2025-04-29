<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(auth()->user()->role->id, [1, 2]);
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'imagen' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser un texto.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',

            'subtitulo.required' => 'El subtítulo es obligatorio.',
            'subtitulo.string' => 'El subtítulo debe ser un texto.',
            'subtitulo.max' => 'El subtítulo no puede tener más de 255 caracteres.',

            'imagen.required' => 'La imagen es obligatoria.',
            'imagen.string' => 'La imagen debe ser una URL o ruta en texto.',

        ];
    }
}
