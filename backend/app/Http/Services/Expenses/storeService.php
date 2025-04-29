<?php

namespace App\Http\Services\Expenses;

use App\Http\Requests\Expenses\FormExpensesRequest;
use App\Http\Services\getDolar;
use App\Http\Services\Provisions\checkService;
use App\Models\Expenses;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeService
{
    static public function index(FormExpensesRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $createdAt = Carbon::now();
            $expensesQuery = Expenses::where('service_id', $request->service)
                ->whereMonth('created_at', $createdAt->month)
                ->whereYear('created_at', $createdAt->year)->first();

            if ($expensesQuery) return response()->json(['message' => 'Ya existe el gasto para el servicio asociado'], 500);

            $expense = new Expenses();
            $dolar = getDolar::getDollarRate();

            $expense->service_id = $request->service;
            $expense->condominium_id = $request->tower == 0 ? null : $request->tower;
            $expense->amount_dollars = $request->mount_dollars;
            $expense->dollar_value = $dolar;
            $expense->mount_fund = $request->mount_dollars;

            if ($request->hasFile('file')) {
                $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $path = $request->file('file')->storeAs('factures/expenses', $filename, 'public');

                if (!$path) {
                    return response()->json(['message' => 'Error al guardar la imagen'], 500);
                }

                $expense->image = "public/factures/expenses/" . $filename;
            }


            $expense->save();

            $provision = checkService::index($request->service, null);

            if (count($provision['ids']) > 0) {
                $provDBs = Provisions::whereIn('id', $provision['ids'])->get();
                $firstProvision = $provDBs->first();

                foreach ($provDBs as $provDB) {
                    $provDB->expense_id = $expense->id;
                    $provDB->save();
                }

                $balance = ProvisionBalance::find($firstProvision->balance_id);

                $current = $balance->current_balance;
                $requested = $request->mount_dollars;
                $remaining = $current - $requested;

                if ($remaining < 0) {
                    // Se usó todo lo que había en provisiones, el resto vino del fondo
                    $expense->mount_prov = $current; // Lo que sí tenía disponible
                    $expense->mount_fund = abs($remaining); // Lo que faltó
                    $balance->current_balance = 0;
                } else {
                    // Provisiones cubrieron todo
                    $expense->mount_prov = $requested;
                    $expense->mount_fund = 0;
                    $balance->current_balance = $remaining;
                }

                $expense->save();
                $balance->save();

                DB::commit();
                return response()->json(["message" => 'Se ha creado correctamente junto a sus provisiones'], 200);
            }
            
            DB::commit();
            return response()->json(["message" => 'Se ha creado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al crear el gasto'], 500);
        }
    }
}
