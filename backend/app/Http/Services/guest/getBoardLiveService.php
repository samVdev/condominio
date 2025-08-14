<?php

namespace App\Http\Services\guest;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class getBoardLiveService
{
    static public function index(string $uuid): JsonResponse
    {
        try {
            $user = auth()->user();

            $boardDB = Board::where('uuid', $uuid)
                ->withCount(['asistentes'])
                ->where('is_active', true)
                ->first();

            if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);

            if ($boardDB->end == false) {
                $boardDB->asistentes()->syncWithoutDetaching([$user->id]);
            }

            $board = [
                'uuid' => $boardDB->uuid,
                'nombre' => $boardDB->name,
                'fecha' => $boardDB->meeting_date,
                'activa' => $boardDB->is_active,
                'description_end' => $boardDB->description_end,
                'description_end' => $boardDB->description_end,
                'statusEnd' => $boardDB->end,
                'enlace' => $boardDB->link ?? '',
                'connectedUsers' => $boardDB->asistentes()->count(),
            ];

            return response()->json($board, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
