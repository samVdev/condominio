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
        $facture = Factures::select('id', 'created_at')->where('code', $request->id)->first();
        $user = auth()->user();
        $persona = $user->persona;
        $dolar = getDolar::getDollarRate();

        $currentDate = Carbon::now();
        $createdAt = Carbon::parse($facture->created_at);

        $isWithinFirstFiveDays = $currentDate->diffInDays($createdAt) < 5;

        $isForMora = $currentDate->diffInDays($createdAt) > 31;

        $receipt = new Receipt();

        $receipt->persona_id = $persona->id;
        $receipt->total_pagado = $request->totalDol;
        $receipt->facture_id = $facture->id;
        $receipt->cedula = $request->cedula;
        $receipt->referencia = $request->ref;
        $receipt->withMora = $isForMora;
        $receipt->withDays = $isWithinFirstFiveDays;
        $receipt->dolarBCV = $dolar;
        $receipt->save();

        return response()->json(['message' => 'Se ha registrado tu pago']);
    }
}
