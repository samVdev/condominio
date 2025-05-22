<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
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
    
            $condominiumDB = Condominium::from('condominium as child')
            ->join('condominium as tower', 'child.condominium_id', '=', 'tower.id')
            ->leftJoin('personas', 'child.id', '=', 'personas.condominium_id')
            ->whereNotNull('child.condominium_id')
            ->select('child.id', 'child.Nombre', 'child.size', 'child.porcent_alicuota as porcent_alicuota', 'tower.Nombre as tower', 'personas.fullName as fullName');
    
            if (!empty($search)) {
                $condominiumDB->where(function ($query) use ($search) {
                    $query->where('child.Nombre', 'ilike', "%{$search}%")
                        ->orWhere('tower.Nombre', 'ilike', "%{$search}%")
                        ->orWhere('personas.fullName', 'ilike', "%{$search}%");
                });
            }
    
            if ($sort) {
                $sortColumns = [
                    'name' => 'child.Nombre',
                    'sizes' => 'child.size',
                    'porcent' => 'child.porcent_alicuota',
                    'tower' => 'child.condominium_id',
                    'persona' => 'personas.fullName'
                ];
    
                if (array_key_exists($sort, $sortColumns)) {
                    $condominiumDB->orderBy($sortColumns[$sort], $direction ?? 'asc');
                }
            }
    
            $condominiumDB = $condominiumDB->skip($offset)->take($limit)->get();
    
            $condominiums = $condominiumDB->map(function ($condominium) {
                return [
                    'id' => $condominium->id,
                    'name' => $condominium->Nombre,
                    'sizes' => $condominium->size ? $condominium->size : 'Sin información',
                    'porcent' => $condominium->porcent_alicuota,
                    'tower' => $condominium->tower,
                    'persona' => $condominium->fullName,
                ];
            });
    
            return response()->json([
                "rows" => $condominiums,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
            ], 200);
    
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
