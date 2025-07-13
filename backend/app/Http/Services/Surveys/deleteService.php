<?php

namespace App\Http\Services\Surveys;

use App\Models\Board;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class deleteService
{
    static public function index(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            if (!$user || !$user->role || $user->role->id != 1) return response()->json(['message' => 'No tienes permiso'], 403);

            $survey = Survey::find($id);

            $board = Board::where('id', $survey->board_id)->where('is_active', true)->first();

            if ($board->end) return response()->json(['message' => 'No se puede eliminar una encuesta si la junta finalizó'], 404);
            if (!$survey) return response()->json(['message' => 'Encuesta no encontrada'], 404);

            $survey->delete();
            DB::commit();

            return response()->json(['message' => 'La encuesta ha sido eliminada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Ocurrió un error al eliminar la encuesta.',
            ], 500);
        }
    }
}
