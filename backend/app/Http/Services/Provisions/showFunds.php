<?php

namespace App\Http\Services\Provisions;

use App\Models\Config;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class showFunds
{
    static public function index(): JsonResponse
    {
        try {
            $balance = ProvisionBalance::sum('current_balance');

            $inicioMes = Carbon::now()->startOfMonth();
            $finMes = Carbon::now()->endOfMonth();
    
            $sum =  Provisions::whereBetween('created_at', [$inicioMes, $finMes])
                ->sum('mount');


            return response()->json([
                'total' => $balance,
                'month' => $sum
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
