<?php

namespace App\Http\Services\Expenses;

use App\Http\Requests\Expenses\editExpensesRequest;
use App\Http\Services\getDolar;
use App\Http\Services\Provisions\checkService;
use App\Models\Elevator;
use App\Models\ElevatorDamageHistory;
use App\Models\Expenses;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class editService
{
    static public function index(editExpensesRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $createdAt = Carbon::now();
            $expensesQuery = Expenses::where('id', '!=', $id)->where('service_id', $request->service)
            ->where('facture_id', null)
            ->whereMonth('created_at', $createdAt->month)
            ->whereYear('created_at', $createdAt->year)->first();
    
            if($expensesQuery) return response()->json(['message' => 'Ya existe el gasto para el servicio asociado'], 500);
    
            $expense = Expenses::where('id', $id)->firstOrFail(); // Mejor usar firstOrFail para capturar si no existe

            if(!$expense || $expense->facture_id) return response()->json(['message' => 'El gasto no se ha encontrado'], 404);
    
            $dolar = getDolar::getDollarRate();
    
            $expense->service_id = $request->service;
            $expense->condominium_id = $request->tower == 0 ? null : $request->tower;
            $expense->mount_fund = $request->mount_dollars;
            $expense->amount_dollars = $request->mount_dollars;
            $expense->dollar_value = $dolar;
    
            if ($request->hasFile('file')) {
                if ($expense->image && Storage::exists($expense->image)) {
                    Storage::delete($expense->image);
                }
    
                $filename = 'expense_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                $request->file('file')->storeAs('factures/expenses', $filename, 'public');
                $expense->image = "public/factures/expenses/" . $filename;
            }
    
            $expense->save();
    
            $provision = checkService::index($request->service, $expense->id);

            if (count($provision['ids']) > 0) {
                $provDBs = Provisions::whereIn('id', $provision['ids'])->get();
                $firstProvision = $provDBs->first();

                foreach ($provDBs as $provDB) {
                    $provDB->expense_id = $expense->id;
                    $provDB->save();
                }

                $balance = ProvisionBalance::find($firstProvision->balance_id);

                $current = $balance->current_balance + $expense->mount_prov;
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


            if ($provision['isForElevator'] == true && $request->elevator) {
                $elevator = Elevator::where('id', $request->elevator)->first();
                if($elevator->operative == false) {
                    $history = new ElevatorDamageHistory();
                    $history->elevator_id = $request->elevator;
                    $history->description = 'Se ha asociado a una factura';
                    $history->status = $elevator->operative;
                    $history->expense_id = $expense->id;
                    $history->save();
                }
            }
    
            DB::commit();
            return response()->json(["message" => 'Se ha editado correctamente'], 200);
   
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Ocurrió un error al editar el gasto."], 500);
        }
    }
}
