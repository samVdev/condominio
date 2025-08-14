<?php

namespace App\Http\Services\TypeEarnings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TypeEarning;


class indexService
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->input("search");
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $direction = $request->input("direction");
            $sort = $request->input("sort");

            $typeEarningsDB = TypeEarning::select('id', 'name', 'created_at');
        
            if (!empty($search)) {
                $typeEarningsDB->where('name', 'ilike', "%{$search}%");
            }
        
            $typeEarningsDB = $typeEarningsDB->skip($offset)->take($limit)->get();
        
            $TypeEarnings = $typeEarningsDB->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'created' => $type->created_at->format('d/m/Y'),
                ];
            });
        
            return response()->json([
                "rows" => $TypeEarnings,
                "sort" => $sort,
                "direction" => $direction,
                "search" => $search,
        ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener los tipos de ingreso'
            ], 500);
        }
    }
}
