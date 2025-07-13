<?php

namespace App\Http\Services\boards;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class deleteService
{
    static public function destroy(string $uuid): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if (!$user || !$user->role || $user->role->id != 1) return response()->json(['message' => 'No tienes permiso'], 403);
            $boardDB = Board::where('uuid', $uuid)
                ->where('end', false)
                ->first();
            if (!$boardDB) return response()->json(['message' => 'Junta no encontrada'], 404);

            $boardDB->delete();
            DB::commit();
            return response()->json(['message' => 'La junta ha sido eliminado correctamente'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Junta no encontrada'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al eliminar la junta.'], 500);
        }
    }
}
