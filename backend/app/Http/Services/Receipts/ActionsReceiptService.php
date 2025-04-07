<?php

namespace App\Http\Services\Receipts;

use App\Http\Requests\Receipts\ReceiptActionsRequest;
use App\Models\Receipt;
use Illuminate\Http\JsonResponse;

class ActionsReceiptService
{

    static public function execute(ReceiptActionsRequest $request): JsonResponse
    {
        $user = auth()->user();
        $receipt = Receipt::find($request->id);
        $message = '';

        if ($receipt->user_id || $receipt->accepted) {
            return response()->json(['message' => 'Ya se ha aceptado este recibo'], 403);
        } elseif ($request->action) {
            $receipt->accepted = $request->action;
            $receipt->user_id = $user->id;
            $receipt->save();
            $message = 'Se ha aceptado correctamente';
        } else {
            $receipt->delete();
            $message = 'Se ha rechazado correctamente';
        }

        return response()->json(['message' => $message]);
    }
}
