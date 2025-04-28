<?php

namespace App\Http\Services\Provisions;

use App\Models\Provisions;
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

            $provision = Provisions::find($id);

            if (!$provision || $provision->facture_id) return response()->json(['message' => 'Provisión no encontrada'], 404);

            $provision->delete();
            DB::commit();

            return response()->json(['message' => 'La provisión ha sido eliminada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Ocurrió un error al eliminar la provisión.',
            ], 500);
        }
    }
}
