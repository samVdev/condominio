<?php

namespace App\Http\Services\Statics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class countendDashService
{
    static public function execute(Request $request): JsonResponse
    {
        $countApt = DB::table('condominium')->whereNotNull('condominium_id')->count();

        // Optimización: Obtener ambos sum() en una sola consulta
        $totales = DB::table('receipts')
            ->selectRaw('SUM(total_pagado) as totalPagado, (SELECT SUM(amount_dollars) FROM expenses) as totalGastos')
            ->first();

        $countTotal = ($totales->totalPagado ?? 0) - ($totales->totalGastos ?? 0);

        // Optimización de fechas
        $gastosMes = DB::table('expenses')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $gastosSemana = DB::table('expenses')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $gastosDia = DB::table('expenses')
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();

        return response()->json([
            "gastosDia" => $gastosDia,
            "gastosSemana" => $gastosSemana,
            "gastosMes" => $gastosMes,
            "countTowerA" => 0,
            "countTowerB" => 0,
            "countTowerC" => 0,
            "countRecibes" => 0,
            "countTotal" => $countTotal,
            "countApt" => $countApt
        ]);
    }
}

