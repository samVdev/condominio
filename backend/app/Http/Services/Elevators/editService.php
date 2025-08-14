<?php

namespace App\Http\Services\Elevators;

use App\Http\Requests\Elevators\editElevatorsRequest;
use App\Models\Condominium;
use App\Models\Elevator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class editService
{
    static public function index(editElevatorsRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $condominio = Condominium::where('id', $request->tower)->first();

            if ($condominio->condominium_id != null) {
                return response()->json([
                    'message' => "No se puede registrar. Debe seleccionar una torre."
                ], 400);
            }
            $elevator = Elevator::where('id', $id)->firstOrFail();
            $elevator->number = $request->number;
            $elevator->condominium_id = $request->tower;
            $elevator->save();
            DB::commit();
            return response()->json(["message" => "Se ha editado correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Ocurrió un error al editar el ascensor."], 500);
        }
    }
}
