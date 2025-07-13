<?php

namespace App\Http\Services\guest;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class boardsActService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $search = $request->input("search");
    
            $boardsDB = Board::from('boards')
            ->select('uuid', 'name', 'description', 'meeting_date', 'is_active')
            ->withCount(['asistentes'])
            ->where('is_active', true);
        
            if (!empty($search)) {
                $boardsDB->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('description', 'ilike', "%{$search}%");
                });
            }
    
            $boardsDB = $boardsDB->skip($offset)->take($limit)->get();
    
            $boards = $boardsDB->map(function ($board) {
                return [
                    'uuid' => $board->uuid,
                    'nombre' => $board->name,
                    'descripcion' => $board->description,
                    'fecha' => $board->meeting_date,
                    'activa' => $board->is_active,
                    'personas' => $board->asistentes_count,
                ];
            });
    
            return response()->json($boards, 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
