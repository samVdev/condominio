<?php

namespace App\Http\Services\Receipts;

use App\Http\Requests\Receipts\RequestStoreReceipts;
use App\Http\Services\getDolar;
use App\Models\Factures;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class storeReceipts
{

    static public function execute(RequestStoreReceipts $request): JsonResponse
    {

        $facture = Factures::select('id', 'mount_exp', 'mount_prov', 'porcent_first_five_days', 'created_at')->where('code', $request->id)->first();

        if (!$facture) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        $user = auth()->user();
        $persona = $user->persona;
        $condominio = $persona->condominium;
        $dolar = getDolar::getDollarRate();

        $currentDate = Carbon::now();
        $createdAt = Carbon::parse($facture->created_at);

        $isWithinFirstFiveDays = $currentDate->diffInDays($createdAt) < 5;
        $isForMora = $currentDate->diffInDays($createdAt) > 31;

        $provMount = $facture->mount_prov;
        $provExp = $facture->mount_exp;

        if ($isWithinFirstFiveDays) {
            // mount descuento provision
            $discountPercentageProv = floatval($facture->porcent_first_five_days);
            $discountAmountProv = $provMount * ($discountPercentageProv / 100);
            $provMount -= $discountAmountProv;

            // mount descuento total gastos
            $discountPercentageExp = floatval($facture->porcent_first_five_days);
            $discountAmountExp = $provExp * ($discountPercentageExp / 100);
            $provExp -= $discountAmountExp;
        }

        if ($isForMora) {
            // mount descuento provision
            $aumentAmountProv = $provMount * (5 / 100);
            $provMount += $aumentAmountProv;

            // mount descuento gastos
            $aumentAmountExp = $provExp * (5 / 100);
            $provExp += $aumentAmountExp;
        }


        $receipt = new Receipt();
        $receipt->persona_id = $persona->id;
        $receipt->total_pagado = $request->totalDol;
        $receipt->facture_id = $facture->id;
        $receipt->cedula = $request->cedula;
        $receipt->referencia = $request->ref;
        $receipt->withMora = $isForMora;
        $receipt->withDays = $isWithinFirstFiveDays;
        $receipt->porcent_alicuota = $condominio->porcent_alicuota;
        $receipt->mount_prov = $provMount * $condominio->porcent_alicuota / 100;
        $receipt->mount_exp = $provExp * $condominio->porcent_alicuota / 100;
        $receipt->dolarBCV = $dolar;
        $receipt->save();

        return response()->json(['message' => 'Se ha registrado tu pago']);
    }
}
