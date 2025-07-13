<?php

namespace App\Http\Services\Surveys;

use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class statusChangeService
{
    static public function index(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $surveyDB = Survey::where('id', $id)->first();

            if (!$surveyDB) return response()->json(['message' => 'Encuesta no encontrada'], 404);
            
            $surveyDB->is_active = !$surveyDB->is_active;

            $surveyDB->save();

            DB::commit();
            return response()->json(["message" => "Se ha cambiado correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al cambiar el estatus de la encuesta'], 500);
        }
    }
}
