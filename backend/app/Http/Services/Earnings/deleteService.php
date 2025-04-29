<?php

namespace App\Http\Services\Earnings;

use App\Models\Earnings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction(); 
        try {
            $user = auth()->user();
    
            if (!$user || $user->role->id !== 1) {
                return response()->json(['message' => 'No tienes permiso'], 403);
            }
    
            $earning = Earnings::find($id);

            if (!$earning || $earning->facture_id) return response()->json(['message' => 'Ingreso no encontrado'], 404);

            if ($earning->image && Storage::disk('public')->exists(str_replace('public/', '', $earning->image))) {
                Storage::disk('public')->delete(str_replace('public/', '', $earning->image));
            }
    
            $earning->delete();
            DB::commit();
    
            return response()->json(['message' => 'El Ingreso ha sido eliminado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al eliminar el ingreso'], 500);
        }
    }
}
