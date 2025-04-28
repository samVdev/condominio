<?php

namespace App\Http\Services\guest;

use App\Models\Expenses;
use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpensesFacture
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $facture = $request->input('facture');

            $factureDB = Factures::where('code', $facture)->first();

            if (!$factureDB) return  response()->json(["message" => "No se encontro la factura"], 403);

            $expensesDB = Expenses::join('services', 'service_id', 'services.id')
                ->select(
                    'expenses.created_at',
                    'services.service_type',
                    'expenses.amount_dollars',
                    'expenses.dollar_value',
                    'image'
                )->where('expenses.facture_id', $factureDB->id);

            $expensesDB = $expensesDB->skip($offset)->take($limit)->get();

            $expenses = $expensesDB->map(function ($expense) {
                $price = (float)$expense->amount_dollars;
                $bcv = (float)$expense->dollar_value;

                return [
                    'name' => $expense->service_type,
                    'tower' => $expense->Nombre,
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $bcv,
                    'dollarBefore' => $expense->dollar_value,
                    'image' => $expense->image,
                    'created' => $expense->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $expenses,
                "sort" => $request->query("sort"),
                "direction" => $request->query("direction"),
                "search" => $request->query("search"),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ocurrió un error al obtener las facturas del usuario"
            ], 500);
        }
    }
}
