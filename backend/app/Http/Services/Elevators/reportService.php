<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
use App\Models\ElevatorDamageHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class reportService
{
    static public function index(Request $request, string $id): JsonResponse
{
    DB::beginTransaction();
    try {
        $elevator = Elevator::where('id', $id)->first();

        if (!$elevator) {
            return response()->json([
                'message' => "No se encuentra el elevador."
            ], 400);
        }

        $elevator->operative = !$elevator->operative;
        $elevator->save();

        $history = new ElevatorDamageHistory();
        $history->elevator_id = $id;
        $history->description = $request->description;
        $history->status = $elevator->operative;

        if ($request->hasFile('file')) {
            $filename = 'elevator_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('history/elevators', $filename, 'public');

            if (!$path) {
                return response()->json(['message' => 'Error al guardar la imagen'], 500);
            }

            $history->image = "public/history/elevators/" . $filename;
        }

        if ($elevator->operative) {
            $lastHistory = ElevatorDamageHistory::where('elevator_id', $id)
                ->whereNotNull('expense_id')
                ->latest()
                ->first();

            if ($lastHistory && $lastHistory->expense_id && $lastHistory->status == false) {
                $history->expense_id = $lastHistory->expense_id;
            }
        }

        $history->save();
        DB::commit();
        return response()->json(["message" => "Se ha guardado correctamente."], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Ocurrió un error al reportar.'], 500);
    }
}

}
