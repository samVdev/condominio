<?php

namespace App\Http\Services\Expenses;

use App\Http\Services\getDolar;
use App\Models\Expenses;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $isSuperAdmin = auth()->user()->role->id == 1;

            if (!$isSuperAdmin) return response()->json(['message' => 'No tienes permiso'], 403);

            $dolar = getDolar::getDollarRate();

            $expenseDB = Expenses::select('id', 'service_id', 'condominium_id', 'amount_dollars', 'image')
                ->where('id', $id)
                ->first();

            if (!$expenseDB) {
                return response()->json(['message' => 'Gasto no encontrado'], 404);
            }

            $service = [
                'id' => $expenseDB->service_id,
                'tower' => $expenseDB->condominium_id ? $expenseDB->condominium_id : '0',
                'service' => $expenseDB->service_id,
                'mount_bs' => $expenseDB->amount_dollars * $dolar,
                'mount_dollars' => $expenseDB->amount_dollars,
                'image' => $expenseDB->image,
            ];

            return response()->json($service, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
