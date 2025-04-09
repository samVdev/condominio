<?php

namespace App\Http\Services\Receipts;

use App\Http\Requests\Receipts\RequestStoreReceipts;
use App\Models\Factures;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;

class storeReceipts
{

    static public function execute(RequestStoreReceipts $request): JsonResponse
    {
        $facture = Factures::select('id')->where('code', $request->id)->first();
        $user = auth()->user();
        $persona = $user->persona;

        $receipt = new Receipt();

        $receipt->persona_id = $persona->id;
        $receipt->total_pagado = $request->totalDol;
        $receipt->facture_id = $facture->id;
        $receipt->cedula = $request->cedula;
        $receipt->referencia = $request->ref;
        $receipt->save();

        return response()->json(['message' => 'Se ha registrado tu pago']);
    }
    
}
