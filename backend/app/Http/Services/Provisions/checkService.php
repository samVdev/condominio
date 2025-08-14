<?php

namespace App\Http\Services\Provisions;

use App\Models\Expenses;
use App\Models\Provisions;
use App\Models\Services;
use Carbon\Carbon;

class checkService
{
    static public function index(string $service_id, $expense_id = null)
    {
        try {
            $expense_id = $expense_id == 0 ? null : $expense_id;

            $createdAt = Carbon::now();

            $service = Services::select('is_for_elevators')->where('id', $service_id)->first();

            $provisionDB = Provisions::select('provisions.id', 'provision_balances.current_balance')
                ->join('provision_balances', 'provisions.balance_id', 'provision_balances.id')
                ->where('provision_balances.service_id', $service_id)
                ->where('number_month', $createdAt->month)
                ->where('expense_id', $expense_id)
                ->whereYear('provisions.created_at', $createdAt->year)
                ->get();

            $uniqueBalances = $provisionDB->unique('balance_id')->sum('current_balance');

            if ($expense_id) {
                $expense = Expenses::where('id', $expense_id)->firstOrFail();
                $uniqueBalances += (float) $expense->mount_prov;
            }

            return [
                'ids' => $provisionDB->pluck('id')->map(fn($id) => (float) $id), // Devuelve todos los IDs como float
                'total' => (float) $uniqueBalances,
                'isForElevator' => $service ? $service->is_for_elevators : false
            ];
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Ocurrió un error al obtener las facturas del usuario"
            ], 500);
        }
    }
}
