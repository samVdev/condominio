<?php

namespace App\Http\Services\Factures;

use App\Http\Requests\Factures\FormFactureRequest;
use App\Http\Services\getDolar;
use App\Models\Expenses;
use App\Models\Factures;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class storeService
{
    static public function index(FormFactureRequest $request): JsonResponse
    {
        $dolar = getDolar::getDollarRate();

        $createdAt = Carbon::now();

        $existingFacture = Factures::where('condominium_id', $request->tower)
            ->whereMonth('fecha', $createdAt->month)
            ->whereYear('fecha', $createdAt->year)
            ->first();


        if ($existingFacture) return response()->json(["message" => 'Ya existe una factura para este mes'], 400);

        $expenses = Expenses::where('condominium_id', $request->tower)
            ->whereNull('facture_id')
            ->whereMonth('created_at', $createdAt->month)
            ->whereYear('created_at', $createdAt->year)
            ->get();


        if ($expenses->isEmpty()) return response()->json(["message" => 'No se ha encontrado ningún gasto en el mes correspondiente'], 404);

        $totalAmount = $expenses->sum('amount_dollars');

        $facture = Factures::create([
            'fecha' => $createdAt->format('Y-m-d'),
            'porcent_first_five_days' => $request->porcent,
            'total_dollars' => $totalAmount,
            'dollar_bcv' => $dolar,
            'condominium_id' => $request->tower,
        ]);

        foreach ($expenses as $expense) {
            $expense->update([
                'facture_id' => $facture->id
            ]);
        }

        return response()->json(["message" => 'Se ha creado correctamente'], 200);
    }
}
