<?php

namespace App\Http\Services\Surveys;

use App\Models\Board;
use Illuminate\Http\JsonResponse;

class getByBoardSurveys
{
    public static function index(string $uuid): JsonResponse
    {
        try {
            $board = Board::where('uuid', $uuid)->first();

            if (!$board) {
                return response()->json(['message' => 'Junta no encontrada'], 404);
            }

            $surveys = $board->surveys()->with('options.responses')->get();

            if ($surveys->isEmpty()) {
                return response()->json(['message' => 'No hay propuestas registradas para esta junta'], 200);
            }

            $formatted = $surveys->map(function ($survey) use ($board) {
                $options = $survey->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'label' => $option->text,
                        'votes' => $option->responses->count()
                    ];
                });

                $hasResponded = $survey->options->flatMap->responses
                ->contains('user_id', auth()->id());

                return [
                    'id' => $survey->id,
                    'question' => $survey->question_text,
                    'options' => $options,
                    'totalPresentes' => $board->asistentes()->count(),
                    'response' =>  $survey->is_active ? $hasResponded : false,
                    'active' =>  $survey->is_active
                ];
            });

            return response()->json($formatted);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener las propuestas',
            ], 500);
        }
    }
}
