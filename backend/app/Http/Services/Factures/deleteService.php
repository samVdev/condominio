<?php

namespace App\Http\Services\Factures;

use App\Models\Factures;
use Illuminate\Http\JsonResponse;


class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        $facture = Factures::find($id);

        if (!$facture) return response()->json(['error' => 'Factura no encontrado'], 404);

        $facture->delete();

        return response()->json(['message' => 'La factura ha sido eliminada correctamente'], 200);
    }
}

