<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        try {

            $condominiumDB = Condominium::select('id', 'Nombre', 'condominium_id', 'size', 'porcent_alicuota')
                ->where('id', $id)
                ->first();

            if (!$condominiumDB) {
                return response()->json(['message' => 'Apartamento no encontrado'], 404);
            }

            $apt = [
                'id' => $condominiumDB->id,
                'name' => $condominiumDB->Nombre,
                'sizes' => $condominiumDB->size,
                'porcent' => $condominiumDB->porcent_alicuota,
                'tower' => $condominiumDB->condominium_id ? $condominiumDB->condominium_id : 0,
            ];

            return response()->json($apt, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
