<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class indexService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $search = $request->input("search");
            $direction = $request->input("direction");
            $sort = $request->input("sort");
    
            $boardsDB = Board::from('boards')
            ->select('uuid', 'name', 'description', 'meeting_date', 'is_active', 'end')
            ->orderBy('id', 'desc');
    
            if (!empty($search)) {
                $boardsDB->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('description', 'ilike', "%{$search}%");
                });
            }
    
            if ($sort) {
                $sortColumns = [
                    'nombre' => 'name',
                    'description' => 'description',
                    'date' => 'meeting_date',
                    'active' => 'is_active',
                    'ended' => 'end',
                ];
    
                if (array_key_exists($sort, $sortColumns)) {
                    $boardsDB->orderBy($sortColumns[$sort], $direction ?? 'asc');
                }
            }
    
            $boardsDB = $boardsDB->skip($offset)->take($limit)->get();
    
            $boards = $boardsDB->map(function ($board) {
                return [
                    'uuid' =>  $board->uuid,
                    'nombre' => $board->name,
                    'descripcion' => $board->description,
                    'fecha' => $board->meeting_date,
                    'activa' => $board->is_active,
                    'statusEnd' => $board->end,
                ];
            });
    
            return response()->json([
                "rows" => $boards,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
