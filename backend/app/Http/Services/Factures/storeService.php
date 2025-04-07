<?php

namespace App\Http\Services\Factures;

use App\Http\Requests\Factures\FormFactureRequest;
use App\Http\Services\getDolar;
use App\Mail\NewFactureEmail;
use App\Models\Expenses;
use App\Models\Factures;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class storeService
{
    static public function index(FormFactureRequest $request): JsonResponse
    {
        $dolar = getDolar::getDollarRate();

        $createdAt = Carbon::now();

        $existingFacture = Factures::whereMonth('fecha', $createdAt->month)
            ->where('number_month', $request->month)
            ->whereYear('fecha', $createdAt->year)
            ->first();

        if ($existingFacture) return response()->json(["message" => 'Ya existe una factura para este mes'], 400);

        $expenses = Expenses::whereNull('facture_id')
            ->whereMonth('created_at', $request->month)
            ->whereYear('created_at', $createdAt->year)
            ->get();


        if ($expenses->isEmpty()) return response()->json(["message" => 'No se ha encontrado ningún gasto en el mes correspondiente'], 404);

        $totalAmount = $expenses->sum('amount_dollars');

        $facture = Factures::create([
            'fecha' => $createdAt->format('Y-m-d'),
            'porcent_first_five_days' => $request->porcent,
            'total_dollars' => $totalAmount,
            'number_month' =>  $request->month,
            'code' => Factures::getCode(),
            'dollar_bcv' => $dolar,
        ]);

        foreach ($expenses as $expense) {
            $expense->update([
                'facture_id' => $facture->id
            ]);
        }


        $validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];

        $emails = User::where(function($query) use ($validDomains) {
            foreach ($validDomains as $domain) {
                $query->orWhere('email', 'like', '%@' . $domain);
            }
        })
        ->pluck('email')
        ->toArray();
        
        $chunks = array_chunk($emails, 10);

        $data = [
            'number_month' => Carbon::createFromDate(2025, $facture->number_month, 1)->locale('es')->monthName,
            'fecha' => Carbon::parse($facture->fecha)->format('d/m/Y'),
            'total_dollars' => $facture->total_dollars,
            'code' => $facture->code,
            'porcent_first_five_days' => $facture->porcent_first_five_days ?? '0',
        ];
        
        foreach ($chunks as $chunk) {
            Mail::to($chunk)->queue(new NewFactureEmail($data));
        }

        return response()->json(["message" => 'Se ha creado correctamente'], 200); 
    }
}
