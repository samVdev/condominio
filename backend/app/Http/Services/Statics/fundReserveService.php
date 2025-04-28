<?php

namespace App\Http\Services\Statics;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class fundReserveService
{
    static public function execute(Request $request): JsonResponse
    {
        try {
            /*
            $totalIngresos = DB::table('earnings')
                ->sum('amount_dollars');

            $totalReceipts = DB::table('receipts')->where('accepted', true)
                ->sum('total_pagado');

            $gastosConProvisiones = DB::table('expenses')
                ->leftJoin('provisions', 'expenses.id', '=', 'provisions.expense_id')
                ->select('expenses.id', 'expenses.amount_dollars', DB::raw('COALESCE(SUM(provisions.mount), 0) as total_provisionado'))
                ->groupBy('expenses.id', 'expenses.amount_dollars')
                ->get();

            $totalGastosReales = 0;

            foreach ($gastosConProvisiones as $gasto) {
                $restante = $gasto->amount_dollars - $gasto->total_provisionado;
                $totalGastosReales += max($restante, 0); 
            }

            $countTotal = ($totalIngresos + $totalReceipts) - $totalGastosReales;
*/

            $totalIngresos = DB::table('earnings')->sum('amount_dollars');

            $totalReceipts = DB::table('receipts')
                ->where('accepted', true)
                ->sum('mount_exp');

            /* $subQuery = DB::table('expenses as e')
                ->leftJoin('provisions as p', 'e.id', '=', 'p.expense_id')
                ->selectRaw('e.id, e.amount_dollars, COALESCE(SUM(p.mount), 0) as total_provisionado')
                ->groupBy('e.id', 'e.amount_dollars');

            $totalGastosReales = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
                ->mergeBindings($subQuery)
                ->selectRaw('SUM(GREATEST(amount_dollars - total_provisionado, 0)) as total')
                ->value('total');*/

            $totalGastosReales = DB::table('expenses')
                ->sum('mount_fund');

            $countTotal = ($totalIngresos + $totalReceipts) - $totalGastosReales;

            return response()->json([
                "countTotal" => $countTotal,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
