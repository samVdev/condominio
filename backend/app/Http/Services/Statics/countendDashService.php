<?php

namespace App\Http\Services\Statics;

use App\Models\Factures;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class countendDashService
{
    static public function execute(Request $request): JsonResponse
    {
        try {

            $gastosMes = DB::table('expenses')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count();

            $gastosSemana = DB::table('expenses')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            $gastosDia = DB::table('expenses')
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->count();


            $condominiumIds = [1, 12, 23, 34];

            $countTowers = User::query()
                ->join('personas', 'users.persona_id', '=', 'personas.id')
                ->join('condominium', 'personas.condominium_id', '=', 'condominium.id')
                ->join('factures', function ($join) {
                    $join->on('factures.id', '>', \DB::raw('0'));
                })
                ->leftJoin('receipts', function ($join) {
                    $join->on('receipts.persona_id', '=', 'personas.id')
                        ->on('receipts.facture_id', '=', 'factures.id');
                })
                ->where(function ($query) {
                    $query->whereNull('receipts.accepted')
                        ->orWhere('receipts.accepted', false);
                })
                ->whereIn('condominium.condominium_id', $condominiumIds)
                ->selectRaw('condominium.condominium_id, count(*) as count')
                ->groupBy('condominium.condominium_id')
                ->pluck('count', 'condominium.condominium_id')
                ->toArray();

            $countTowerA = $countTowers[1] ?? 0;
            $countTowerB = $countTowers[12] ?? 0;
            $countTowerC = $countTowers[23] ?? 0;
            $countTowerD = $countTowers[34] ?? 0;

            return response()->json([
                "gastosDia" => $gastosDia,
                "gastosSemana" => $gastosSemana,
                "gastosMes" => $gastosMes,
                "countTowerA" =>  $countTowerA,
                "countTowerB" =>  $countTowerB,
                "countTowerC" =>  $countTowerC,
                "countTowerD" => $countTowerD,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
