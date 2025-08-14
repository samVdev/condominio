<?php

namespace App\Http\Services\Condominium;

use App\Http\Requests\Condominium\FormCondominiumRequest;
use App\Models\Condominium;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeService
{
    static public function index(FormCondominiumRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $totalPorcent = Condominium::sum('porcent_alicuota');

        $nuevoPorcent = $request->porcent;
        $disponible = 100 - $totalPorcent;

        if ($nuevoPorcent > $disponible) {
            return response()->json([
                'message' => "No se puede registrar. Solo queda disponible $disponible% de alicuota."
            ], 400);
        }

        try {
            $condominio = new Condominium();
            $condominio->Nombre = $request->name;
            $condominio->size = $request->sizes;
            $condominio->porcent_alicuota = $request->porcent;
            $condominio->condominium_id = $request->tower;
            $condominio->save();
            DB::commit();
            return response()->json(["message" => "Se ha guardado correctamente. Solo queda disponible $disponible% de alicuota"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al crear el apartamento'], 500);
        }
    }
}
