<?php

namespace App\Http\Services\Factures;

use App\Http\Requests\Factures\FormFactureRequest;
use App\Http\Services\getDolar;
use App\Mail\NewFactureEmail;
use App\Models\Earnings;
use App\Models\Expenses;
use App\Models\Factures;
use App\Models\Provisions;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class storeService
{
    static public function index(FormFactureRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $dolar = getDolar::getDollarRate();
            $createdAt = Carbon::now();

            $existingFacture = Factures::whereMonth('fecha', $createdAt->month)
                ->where('number_month', $request->month)
                ->whereYear('fecha', $createdAt->year)
                ->first();

            if ($existingFacture) {
                return response()->json(["message" => 'Ya existe una factura para este mes'], 400);
            }

            $expenses = Expenses::whereNull('facture_id')
                ->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $createdAt->year)->get();


            if ($expenses->isEmpty()) {
                return response()->json(["message" => 'No se ha encontrado ningún gasto en el mes correspondiente'], 404);
            }

            $totalExpenses = $expenses->sum('mount_fund');

            /*$MountExpenses = $expenses->reduce(function ($carry, $expense) {
                $provision = $expense->provisions->first();
            
                if ($provision) {
                    // Resta entre el monto del expense y la provisión
                    $carry += $expense->amount_dollars - $provision->mount;
                } else {
                    // Si no hay provisión, se suma el monto completo
                    $carry += $expense->amount_dollars;
                }
            
                return $carry;
            }, 0);*/
            

            $totalProv = 0;

            $provisions = Provisions::whereYear('created_at', $createdAt->year)
                ->whereMonth('created_at', $createdAt->month)
                ->get();

            if ($provisions->isNotEmpty()) {
                $totalProv += $provisions->sum('mount');
            }

            $totalMount = $totalProv + $totalExpenses;

            $facture = Factures::create([
                'fecha' => $createdAt->format('Y-m-d'),
                'porcent_first_five_days' => $request->porcent,
                'total_dollars' => $totalMount,
                'mount_prov' => $totalProv,
                'mount_exp' => $totalExpenses,
                'number_month' =>  $request->month,
                'code' => Factures::getCode(),
                'dollar_bcv' => $dolar,
            ]);

            foreach ($provisions as $provision) {
                $provision->update(['facture_id' => $facture->id]);
            }

            foreach ($expenses as $expense) {
                $expense->update(['facture_id' => $facture->id]);
            }

            $earnings = Earnings::whereNull('facture_id')
                ->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $createdAt->year)
                ->get();

            $message = null;
            if ($earnings->isEmpty()) {
                $message = 'No se encontraron ingresos';
            } else {
                foreach ($earnings as $earning) {
                    $earning->update(['facture_id' => $facture->id]);
                }
            }

            DB::commit();

            $validDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
            $emails = User::where(function ($query) use ($validDomains) {
                foreach ($validDomains as $domain) {
                    $query->orWhere('email', 'like', '%@' . $domain);
                }
            })->pluck('email')->toArray();

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

            return response()->json([
                "message" => 'Se ha creado correctamente',
                "messEar" => $message
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Ocurrió un error al crear la factura."], 500);
        }
    }
}
