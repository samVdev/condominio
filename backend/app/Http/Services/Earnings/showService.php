<?php

namespace App\Http\Services\Earnings;

use App\Http\Services\getDolar;
use App\Models\Earnings;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        $isSuperAdmin = auth()->user()->role->id == 1;
    
        if (!$isSuperAdmin) return response()->json(['message' => 'No tienes permiso'], 403);
    
        try {
            $dolar = getDolar::getDollarRate();
    
            $earningDB = Earnings::select('id', 'type_id', 'condominium_id', 'amount_dollars', 'image')
                                ->where('id', $id)
                                ->first();
    
            if (!$earningDB) {
                return response()->json(['message' => 'Ingreso no encontrado'], 404);
            }
    
            $service = [
                'id' => $earningDB->id,
                'tower' => $earningDB->condominium_id ? $earningDB->condominium_id : '0',
                'type' => $earningDB->type_id,
                'mount_bs' => $earningDB->amount_dollars * $dolar,
                'mount_dollars' => $earningDB->amount_dollars,
                'image' => $earningDB->image,
            ];
    
            return response()->json($service, 200);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al obtener el ingreso'], 500);
        }
    }
}
