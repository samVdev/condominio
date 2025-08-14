<?php

namespace App\Http\Services\Condominium;

use App\Models\Condominium;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class getAptsService
{
    static public function get(?string $uuid = null): JsonResponse
    {
        try {
            $availableApts = Condominium::from('condominium as child')
                ->join('condominium as tower', 'child.condominium_id', '=', 'tower.id')
                ->whereNotNull('child.condominium_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('personas')
                          ->whereColumn('personas.condominium_id', 'child.id');
                })
                ->select(
                    'child.id',
                    DB::raw('CONCAT("tower"."Nombre", \' - \', "child"."Nombre") as name')
                );

            if ($uuid) {
                $userApt = DB::table('users')
                    ->join('personas', 'users.persona_id', '=', 'personas.id')
                    ->join('condominium as child', 'personas.condominium_id', '=', 'child.id')
                    ->join('condominium as tower', 'child.condominium_id', '=', 'tower.id')
                    ->where('users.uuid', $uuid)
                    ->select(
                        'child.id',
                        DB::raw('CONCAT("tower"."Nombre", \' - \', "child"."Nombre") as name')
                    );

                $condominiums = $availableApts
                    ->union($userApt)
                    ->get();
            } else {
                $condominiums = $availableApts->get();
            }

            return response()->json($condominiums, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
