<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
use Illuminate\Http\JsonResponse;

class getMinService
{
    static public function index(): JsonResponse
    {
        try {
            $ElevatorsDB = Elevator::from('elevators')
            ->join('condominium', 'elevators.condominium_id', '=', 'condominium.id')
            ->select('condominium.Nombre', 'condominium.id as towerID', 'number', 'elevators.id',)->where('operative', false)->get();

            $Elevators = $ElevatorsDB->map(function ($Elevators) {
                return [
                    'id' => $Elevators->id,
                    'number' => $Elevators->number,
                    'tower' => $Elevators->Nombre,
                    'tower_id' => $Elevators->towerID,
                    'status' => $Elevators->operative,
                ];
            });
    
            return response()->json($Elevators, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
