<?php

namespace App\Http\Services\Surveys;

use App\Http\Requests\Surveys\StoreSurveyRequest;
use App\Models\Survey;
use App\Models\Option;
use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeSurveys
{
    static public function index(StoreSurveyRequest $request, string $uuid): JsonResponse
    {

        DB::beginTransaction();

        try {
            $board = Board::where('uuid', $uuid)->where('is_active', true)->first();

            $survey = Survey::create([
                'board_id' => $board->id,
                'question_text' => $request->question_text,
                'is_active' => true
            ]);

            // Crear opciones
            foreach ($request->options as $text) {
                Option::create([
                    'survey_id' => $survey->id,
                    'text' => $text
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Encuesta creada exitosamente',
                'survey_id' => $survey->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la encuesta',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}

