<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
use Illuminate\Http\JsonResponse;

class countService
{
    static public function index(): JsonResponse
    {
        try {
            $total = Elevator::count();
            $opertives = Elevator::where('operative', true)->count();
            $damaged = Elevator::where('operative', false)->count();
            
            return response()->json([
                'count' => $total,
                'opertives' => $opertives,
                'damaged' => $damaged
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
