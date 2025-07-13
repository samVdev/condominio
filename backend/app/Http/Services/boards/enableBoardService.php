<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class enableBoardService
{
    static public function index(string $uuid): JsonResponse
    {
        DB::beginTransaction();
        try {
            $boardDB = Board::where('uuid', $uuid)
                ->where('end', false)
                ->first();

            if (!$boardDB) {
                return response()->json(['message' => 'Junta no encontrada'], 404);
            }

            $boardDB->is_active = !$boardDB->is_active;

            if ($boardDB->is_active && is_null($boardDB->started_at)) {
                $boardDB->started_at = Carbon::now();
            }

            $boardDB->save();

            DB::commit();
            return response()->json(["message" => "Se ha cambiado el estatus correctamente."], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al cambiar el estatus de la junta'], 500);
        }
    }
}
