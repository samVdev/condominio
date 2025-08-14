<?php

namespace App\Http\Requests\Surveys;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'question_text' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'question_text.required' => 'La pregunta de la encuesta es obligatoria.',
            'question_text.string' => 'La pregunta debe ser un texto válido.',
            'question_text.max' => 'La pregunta no puede tener más de 255 caracteres.',

            'options.required' => 'Debes proporcionar al menos dos opciones de respuesta.',
            'options.array' => 'Las opciones deben ser una lista.',
            'options.min' => 'Debes proporcionar al menos dos opciones de respuesta.',

            'options.*.required' => 'Cada opción debe tener texto.',
            'options.*.string' => 'Cada opción debe ser un texto válido.',
            'options.*.max' => 'Cada opción no puede superar los 255 caracteres.'
        ];
    }
}
