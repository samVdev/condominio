<?php

namespace App\Http\Services\Provisions;

use App\Http\Requests\Provisions\FormProvisionsRequest;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class storeService
{
    static public function index(FormProvisionsRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $createdAt = Carbon::now();
            
            // Obtener o crear el balance
            $balance = ProvisionBalance::firstOrCreate(
                ['service_id' => $request->service],
                ['current_balance' => 0.00]
            );

            $provision = new Provisions();
            $provision->condominium_id = $request->tower == 0 ? null : $request->tower;
            $provision->mount = $request->mount_dollars;
            $provision->number_month = $request->month;
            $provision->balance_id = $balance->id;

            $provision->save();

            DB::commit();

            return response()->json(["message" => 'Se ha creado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => "Ocurrió un error al crear la provisión",
            ], 500);
        }
    }
}
