<?php

namespace App\Http\Services\Receipts;

use App\Http\Requests\Receipts\ReceiptActionsRequest;
use App\Models\Config;
use App\Models\Expenses;
use App\Models\ProvisionBalance;
use App\Models\Provisions;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;

class ActionsReceiptService
{

    static public function execute(ReceiptActionsRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $receipt = Receipt::find($request->id);
            $message = '';

            if (!$receipt) return response()->json(['message' => 'Recibo no encontrado'], 404);

            if ($receipt->user_id || $receipt->accepted) {
                // en caso de que se halla aceptado el recibo previamente
                return response()->json(['message' => 'Ya se ha aceptado este recibo'], 403);
            } elseif ($request->action) {
                // en caso de aceptar el recibo

                $receipt->accepted = $request->action;
                $receipt->user_id = $user->id;

                $expenses = Expenses::where('facture_id', $receipt->facture_id)->get();

                if ($expenses->isEmpty()) {
                    return response()->json(["message" => 'No se ha encontrado ningún gasto en el mes correspondiente'], 404);
                }

                $provisions = Provisions::where('facture_id', $receipt->facture_id)->get();

                if ($provisions->isNotEmpty()) {
                    $alicuota = floatval($receipt->porcent_alicuota ?? 0);

                    foreach ($provisions as $provision) {
                        $mountAlicuot = abs($provision->mount * ($alicuota / 100));
                        $provision->paid += $mountAlicuot; 
                        ProvisionBalance::where('id', $provision->balance_id)->increment('current_balance', $mountAlicuot);
                        $provision->save();
                    }
                }

                $receipt->save();

                $message = 'Se ha aceptado correctamente';
            } else {
                // en caso de rechazar el recibo
                $receipt->delete();
                $message = 'Se ha rechazado correctamente';
            }

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado al procesar el recibo'
            ], 500);
        }
    }
}
