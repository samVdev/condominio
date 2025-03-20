<?php

namespace App\Http\Services\Statics;

use Illuminate\Http\{
  Request,
};

use App\Models\Condominium;
use Illuminate\Support\Facades\DB;

class countendDashService
{

  static public function execute(Request $request): \Illuminate\Http\JsonResponse
  {
    $countApt = Condominium::whereNotNull('condominium_id')->count();

    // Sumar todos los pagos en la tabla 'receipts'
    $totalPagado = DB::table('receipts')
      ->sum('total_pagado');

    $totalGastos = DB::table('expenses')
      ->sum('amount_dollars');

    $countTotal = $totalPagado - $totalGastos;

    $gastosMes = DB::table('expenses')
    ->whereMonth('created_at', '=', now()->month) // Filtra por el mes actual
    ->count();


    $gastosSemana = DB::table('expenses')
    ->whereBetween('created_at', [
        now()->startOfWeek(), // Inicio de la semana (domingo o lunes dependiendo de la configuración)
        now()->endOfWeek() // Fin de la semana
    ])
    ->count();

    $gastosDia = DB::table('expenses')
    ->whereDate('created_at', '=', now()->toDateString()) // Filtra por la fecha actual
    ->count();


    return response()->json([
      "gastosDia" => $gastosDia,
      "gastosSemana" => $gastosSemana,
      "gastosMes" => $gastosMes,
      "countTowerA" => 0,
      "countTowerB" =>  0,
      "countTowerC" => 0,
      "countRecibes" => 0,
      "countTotal" => $countTotal,
      "countApt" => $countApt
    ]);
  }
}
