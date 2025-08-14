<?php

namespace App\Http\Services\Surveys;

use App\Http\Requests\Surveys\StoreSurveyResponseRequest;
use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class newResponseSurvey
{

    static public function index(StoreSurveyResponseRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();

            $board = Board::where('uuid', $request->board)->first();

            if (!$board->is_active || $board->end) {
                return response()->json(['message' => 'La junta no está activa o ya ha finalizado'], 403);
            }

            $estaPresente = $board->asistentes()
                ->where('user_id', $user->id)
                ->exists();

            if (!$estaPresente) {
                return response()->json(['message' => 'Debes estar conectado a la junta para responder'], 403);
            }

            $survey = $board->surveys()->where('id', $request->survey)->first();
            if (!$survey) {
                return response()->json(['message' => 'Encuesta no válida para esta junta'], 404);
            }

            if (!$survey->is_active) {
                return response()->json(['message' => 'Encuesta inactiva'], 403);
            }

            $option = $survey->options()->where('id', $request->selected)->first();
            if (!$option) {
                return response()->json(['message' => 'Opción inválida para esta encuesta'], 400);
            }

            $yaRespondio = $option->responses()
                ->where('user_id', $user->id)
                ->exists();

            if ($yaRespondio) {
                return response()->json(['message' => 'Ya has respondido esta encuesta'], 409);
            }

            $option->responses()->create([
                'user_id' => $user->id,
                'survey_id' => $request->survey
            ]);

            DB::commit();

            return response()->json(['message' => 'Respuesta registrada con éxito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la encuesta',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
