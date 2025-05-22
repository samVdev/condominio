<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;

class countService
{
    static public function index(): JsonResponse
    {
        try {
            $condominiumCount = Condominium::count();
            $total = Condominium::sum('porcent_alicuota');
            $rounded = round($total, 2);

            return response()->json([
                'porcent' => $rounded,
                'count' => $condominiumCount
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
