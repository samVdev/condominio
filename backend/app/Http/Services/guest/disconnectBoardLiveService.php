<?php

namespace App\Http\Services\guest;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class disconnectBoardLiveService
{
    static public function index(Request $request, string $uuid): JsonResponse
    {
        try {
            $user = auth()->user();

            $boardDB = Board::where('uuid', $uuid)
            ->where('is_active', true)
            ->first();

            if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);
            
            if($boardDB->end == false) {
                $boardDB->asistentes()->detach($user->id);
            }

            return response()->json([], 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
