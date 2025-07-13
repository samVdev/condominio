<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $uuid): JsonResponse
    {
        try {
            $user = auth()->user();

            $boardDB = Board::where('uuid', $uuid)->first();

            if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);
            
            /*if ($boardDB->end == false) {
                $boardDB->asistentes()->syncWithoutDetaching([$user->id]);
            }*/

            $board = [
                'uuid' => $boardDB->uuid,
                'nombre' => $boardDB->name,
                'fecha' => $boardDB->meeting_date,
                'activa' => $boardDB->is_active,
                'description_end' => $boardDB->description_end,
                'statusEnd' => $boardDB->end,
                'enlace' => $boardDB->link ?? '',
                'duration' => $boardDB->end ? $boardDB->getTime() : null
            ];
            return response()->json($board, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Junta no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al obtener la junta.'], 500);
        }
    }
}
