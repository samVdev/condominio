<?php

namespace App\Http\Services\Factures;

use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $facture = Factures::find($id);

            if (!$facture) return response()->json(['message' => 'Factura no encontrada'], 404);
            
            $facture->delete();

            DB::commit();
    
            return response()->json(['message' => 'La factura ha sido eliminada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json(['message' => 'Ocurrió un error al eliminar la factura'], 500);
        }
    }
}

