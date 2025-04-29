<?php

namespace App\Http\Services\guest;

use App\Http\Services\getDolar;
use App\Models\Factures;
use App\Models\Provisions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProvisionsFacture
{
    static public function index(Request $request): JsonResponse
    {
        try {
            $offset = (int)$request->input("offset", 0);
            $limit = (int)$request->input("limit", 10);
            $facture = $request->input('facture');

            $factureDB = Factures::where('code', $facture)->first();

            $dolarBCV = getDolar::getDollarRate();

            if (!$factureDB) return  response()->json(["message" => "No se encontro la factura"], 403);

            $provisionsDB = Provisions::leftjoin('condominium', 'provisions.condominium_id', 'condominium.id')
                ->join('provision_balances', 'provisions.balance_id', 'provision_balances.id')
                ->join('services', 'service_id', 'services.id')
                ->select(
                    'provisions.id',
                    'service_id',
                    'provisions.condominium_id',
                    'provisions.created_at',
                    'services.service_type',
                    'condominium.Nombre',
                    'provisions.mount',
                    'provisions.number_month'
                )->where('provisions.facture_id', $factureDB->id);

            $provisionsDB = $provisionsDB->skip($offset)->take($limit)->get();

            $provisions = $provisionsDB->map(function ($provision) use ($dolarBCV){
                $price = (float)$provision->mount;

                return [
                    'name' => $provision->service_type,
                    'tower' => $provision->Nombre,
                    'mount_dollars' => $price,
                    'mount_bs' => $price * $dolarBCV,
                    'created' => $provision->created_at->format('d/m/Y'),
                ];
            });

            return response()->json([
                "rows" => $provisions,
                "sort" => $request->query("sort"),
                "direction" => $request->query("direction"),
                "search" => $request->query("search"),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ocurrió un error al obtener las provisiones"
            ], 500);
        }
    }
}
