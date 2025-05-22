<?php

namespace App\Http\Services\Condominium;

use App\Http\Requests\Condominium\editCondominiumRequest;
use App\Models\Condominium;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class editService
{
    static public function index(editCondominiumRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        $totalPorcent = Condominium::where('id', '!=', $id)->sum('porcent_alicuota');

        $nuevoPorcent = $request->porcent;
        $disponible = 100 - $totalPorcent;

        if ($nuevoPorcent > $disponible) {
            return response()->json([
                'message' => "No se puede registrar. Solo queda disponible $disponible% de alicuota."
            ], 400);
        }

        try {
            $condominio = Condominium::where('id', $id)->firstOrFail();
            $condominio->Nombre = $request->name;
            $condominio->size = $request->sizes;
            $condominio->porcent_alicuota = $request->porcent;
            $condominio->condominium_id = $request->tower;
            $condominio->save();
            DB::commit();
            return response()->json(["message" => "Se ha editado correctamente. Solo queda disponible $disponible% de alicuota"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Ocurrió un error al editar el gasto."], 500);
        }
    }
}
