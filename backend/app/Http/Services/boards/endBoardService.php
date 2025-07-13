<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class endBoardService
{
    static public function index(Request $request, string $uuid): JsonResponse
    {
        DB::beginTransaction();
        try {
            $boardDB = Board::where('uuid', $uuid)
                ->where('end', false)
                ->first();

            if (!$boardDB) {
                return response()->json(['message' => 'Junta no encontrada'], 404);
            }

            $boardDB->is_active = false;
            $boardDB->end = true;
            $boardDB->description_end = $request->descripcion ?? null;
            $boardDB->ended_at = Carbon::now();

            $boardDB->save();

            DB::commit();
            return response()->json(["message" => "Se ha culminado la junta correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al cambiar el estatus de la junta'], 500);
        }
    }
}
