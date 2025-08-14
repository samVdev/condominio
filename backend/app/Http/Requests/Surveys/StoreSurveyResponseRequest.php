<?php

namespace App\Http\Requests\Surveys;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // o validar permisos si es necesario
    }

    public function rules(): array
    {
        return [
            'board' => ['required', 'uuid', 'exists:boards,uuid'],
            'survey' => ['required', 'integer', 'exists:surveys,id'],
            'selected' => ['required', 'integer', 'exists:options,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'board.required' => 'La junta es obligatoria',
            'board.exists' => 'La junta no existe',
            'survey.exists' => 'La encuesta no existe',
            'selected.exists' => 'La opción seleccionada no existe',
        ];
    }
}
