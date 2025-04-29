<?php

namespace App\Http\Services\TypeEarnings;

use Illuminate\Http\JsonResponse;
use App\Models\TypeEarning;

class deleteService
{
    static public function destroy(string $id): JsonResponse
    {
        try {
            $type = TypeEarning::find($id);
        
            if (!$type) return response()->json(['message' => 'Tipo de ingreso no encontrado'], 404);
        
            $type->delete();
        
            return response()->json(['message' => 'Tipo de ingreso eliminado correctamente'], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado al eliminar el tipo de ingreso'
            ], 500);
        }
    }
}

