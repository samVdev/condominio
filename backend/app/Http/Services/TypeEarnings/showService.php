<?php

namespace App\Http\Services\TypeEarnings;

use Illuminate\Http\JsonResponse;
use App\Models\TypeEarning;


class showService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $sypeEarningsDB = TypeEarning::select('name')->where('id', $id)->first();
        
            if (!$sypeEarningsDB) return response()->json(['message' => 'Tipo de ingreso no encontrado'], 404);
        
            $service = [          
                'name' => $sypeEarningsDB->name,               
            ];
        
            return response()->json($service, 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al obtener el tipo de ingreso'
            ], 500);
        }
        
    }
}
