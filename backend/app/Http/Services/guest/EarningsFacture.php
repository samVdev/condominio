<?php

namespace App\Http\Services\guest;

use App\Models\Earnings;
use App\Models\Expenses;
use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EarningsFacture
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $facture = $request->input('facture');

            $factureDB = Factures::where('code', $facture)->first();

            if (!$factureDB) return  response()->json(["message" => "No se encontro la factura"], 403);

            $earningsDB = Earnings::join('type_earnings', 'type_id', 'type_earnings.id')
            ->leftjoin('condominium', 'earnings.condominium_id', 'condominium.id')
            ->select(
                'earnings.id',
                'type_id',
                'earnings.condominium_id',
                'earnings.created_at',
                'type_earnings.name',
                'condominium.Nombre',
                'earnings.amount_dollars',
                'earnings.dollar_value',
                'image'
            );

            $earningsDB = $earningsDB->skip($offset)->take($limit)->get();

            $earnings = $earningsDB->map(function ($earning) {
                $price = (float)$earning->amount_dollars;
                $bcv = (float)$earning->dollar_value;

                return [
                    'name' => $earning->name,
                    'tower' => $earning->Nombre,
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $bcv,
                    'dollarBefore' => $earning->dollar_value,
                    'created' => $earning->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $earnings,
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
