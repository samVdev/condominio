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
        
            $typeEarningsDB = TypeEarning::select('id', 'name', 'created_at');
        
            if (!empty($search)) {
                $typeEarningsDB->where('name', 'ilike', "%{$search}%");
            }
        
            $typeEarningsDB = $typeEarningsDB->get();
        
            $TypeEarnings = $typeEarningsDB->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'created' => $type->created_at->format('d/m/Y'),
                ];
            });
        
            return response()->json($TypeEarnings, 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener los tipos de ingreso'
            ], 500);
        }
    }
}
