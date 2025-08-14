<?php

namespace App\Http\Services\Elevators;

use App\Models\Elevator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            if (!$user || !$user->role || $user->role->id != 1) return response()->json(['message' => 'No tienes permiso'], 403);

            $elevator = Elevator::find($id);

            if (!$elevator) return response()->json(['message' => 'elevador no encontrado'], 404);

            $elevator->delete();
            DB::commit();
            return response()->json(['message' => 'El elevador ha sido eliminado correctamente'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Elevador no encontrado'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al eliminar el elevador.'], 500);
        }
    }
}
