<?php

namespace App\Http\Services\Provisions;

use App\Http\Requests\Provisions\editProvisionsRequest;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class editService
{
    static public function index(editProvisionsRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $provision = Provisions::where('id', $id)->first();

            if (!$provision || $provision->facture_id) return response()->json(['message' => 'Provisión no encontrada'], 404);

            $balance = ProvisionBalance::firstOrCreate(
                ['service_id' => $request->service],
                ['current_balance' => 0.00]
            );

            $provision->condominium_id = $request->tower == 0 ? null : $request->tower;
            $provision->mount = $request->mount_dollars;
            $provision->number_month = $request->month;
            $provision->balance_id = $balance->id;

            $provision->save();
            DB::commit();

            return response()->json(["message" => 'Se ha editado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Ocurrió un error al editar la provisión.',
            ], 500);
        }
    }
}
