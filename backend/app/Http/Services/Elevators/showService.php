<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
use Illuminate\Http\JsonResponse;

class showService
{
    static public function index(string $id): JsonResponse
    {
        try {

            $ElevatorsDB = Elevator::select('id', 'number', 'condominium_id')
                ->where('id', $id)
                ->first();

            if (!$ElevatorsDB) {
                return response()->json(['message' => 'Elevador no encontrado'], 404);
            }

            $apt = [
                'id' => $ElevatorsDB->id,
                'number' => $ElevatorsDB->number,
                'tower' => $ElevatorsDB->condominium_id ? $ElevatorsDB->condominium_id : 0,
            ];

            return response()->json($apt, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
