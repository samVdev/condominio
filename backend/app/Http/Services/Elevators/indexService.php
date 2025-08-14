<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
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
    
            $ElevatorsDB = Elevator::from('elevators')
            ->join('condominium', 'elevators.condominium_id', '=', 'condominium.id')
            ->select('condominium.Nombre', 'number', 'elevators.id', 'elevators.operative');
    
            if (!empty($search)) {
                $ElevatorsDB->where(function ($query) use ($search) {
                    $query->where('elevators.number', 'ilike', "%{$search}%")
                        ->orWhere('condominium.Nombre', 'ilike', "%{$search}%");
                });
            }
    
            if ($sort) {
                $sortColumns = [
                    'number' => 'number',
                    'tower' => 'condominium.id',
                    'status' => 'operative',
                ];
    
                if (array_key_exists($sort, $sortColumns)) {
                    $ElevatorsDB->orderBy($sortColumns[$sort], $direction ?? 'asc');
                }
            }
    
            $ElevatorsDB = $ElevatorsDB->skip($offset)->take($limit)->get();
    
            $Elevators = $ElevatorsDB->map(function ($Elevators) {
                return [
                    'id' => $Elevators->id,
                    'number' => $Elevators->number,
                    'tower' => $Elevators->Nombre,
                    'status' => $Elevators->operative,
                ];
            });
    
            return response()->json([
                "rows" => $Elevators,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
