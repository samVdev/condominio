<?php

namespace App\Http\Services\TypeEarnings;

use Illuminate\Http\JsonResponse;
use App\Models\TypeEarning;


class getMiniumService
{
    static public function index(): JsonResponse
    {
        try {
            $typeEarningsDB = TypeEarning::select('id', 'name')->get();
        
            $TypeEarnings = $typeEarningsDB->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
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
