<?php

namespace App\Http\Services\Expenses;

use App\Http\Services\getDolar;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        $isSuperAdmin = auth()->user()->role->id == 1; // superAdmin

        if (!$isSuperAdmin)return response()->json(['message' => 'No tienes permiso'], 400);

        $dolar = getDolar::getDollarRate();

        $expenseDB = Expenses::select('id', 'service_id', 'condominium_id', 'amount_dollars', 'image')->where('id', $id)->first();

        $service = [          
            'id' => $expenseDB->service_id,               
            'tower' => $expenseDB->condominium_id,
            'service' => $expenseDB->service_id,
            'mount_bs' => $expenseDB->amount_dollars * $dolar,
            'image' => $expenseDB->image,
        ];

        return response()->json($service, 200);
    }
}
