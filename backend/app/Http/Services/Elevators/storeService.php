<?php

namespace App\Http\Services\Elevators;

use App\Http\Requests\Elevators\FormElevatorsRequest;
use App\Models\Condominium;
use App\Models\Elevator;
use App\Models\ElevatorDamageHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeService
{
    static public function index(FormElevatorsRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $condominio = Condominium::where('id', $request->tower)->first();

            if ($condominio->condominium_id != null) {
                return response()->json([
                    'message' => "No se puede registrar. Debe seleccionar una torre."
                ], 400);
            }
            
            $elevator = new Elevator();
            $elevator->number = $request->number;
            $elevator->condominium_id = $request->tower;
            $elevator->save();


            $history = new ElevatorDamageHistory();
            $history->elevator_id = $elevator->id;
            $history->description= 'Sin detalles';
            $history->status= true;
            $history->save();

            DB::commit();
            return response()->json(["message" => "Se ha guardado correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al crear el apartamento'], 500);
        }
    }
}
