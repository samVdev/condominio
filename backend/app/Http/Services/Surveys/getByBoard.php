<?php

namespace App\Http\Services\Surveys;

use App\Models\Board;
use Illuminate\Http\JsonResponse;

class getByBoard
{
    static public function index(string $uuid): JsonResponse
    {
        try {
            $board = Board::where('uuid', $uuid)->first();
            $survey = $board->surveys()->with('options.responses')->where('is_active', true)->first();

            if (!$survey) {
                return response()->json(['message' => 'No hay encuesta activa para esta junta'], 404);
            }
    
            $optionsFormatted = $survey->options->map(function ($option) {
                return [
                    'label' => $option->text,
                    'votes' => $option->responses->count()
                ];
            });
    
            return response()->json([
                'question' => $survey->question_text,
                'options' => $optionsFormatted,
                'totalPresentes' => $board->asistentes()->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener las propuestas'
            ], 500);
        }
        
    }
}
