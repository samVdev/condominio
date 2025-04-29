<?php

namespace App\Http\Services\Provisions;

use App\Http\Services\getDolar;
use App\Models\Provisions;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $isSuperAdmin = auth()->user()->role->id == 1; // superAdmin

            if (!$isSuperAdmin) return response()->json(['message' => 'No tienes permiso'], 400);

            $dolar = getDolar::getDollarRate();

            $provisionsDB = Provisions::select('service_id', 'condominium_id', 'mount', 'number_month')
            ->join('provision_balances', 'provisions.balance_id', 'provision_balances.id')
            ->join('services', 'service_id', 'services.id')
            ->where('provisions.id', $id)->first();

            $service = [
                'id' => $provisionsDB->service_id,
                'tower' => '0',
                'service' => $provisionsDB->service_id,
                'mount_bs' => $provisionsDB->mount * $dolar,
                'month' => $provisionsDB->number_month,
                'mount_dollars' => $provisionsDB->mount,
            ];

            return response()->json($service, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
