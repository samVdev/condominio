<?php

namespace App\Http\Services\TypeEarnings;

use App\Http\Requests\TypeEarnings\TypeEarningEditRequest;
use Illuminate\Http\JsonResponse;
use App\Models\TypeEarning;

class editService
{
    static public function index(TypeEarningEditRequest $request, string $id): JsonResponse
    {
        try {
            $typeEarning = TypeEarning::where('id', $id)->first();
        
            if (!$typeEarning) {
                return response()->json(["message" => "Tipo de ingreso no encontrado"], 404);
            }
        
            $typeEarning->name = $request->name;
        
            $typeEarning->save();
        
            return response()->json(["message" => 'Se ha editado correctamente'], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ocurrió un error inesperado al editar el tipo de ingreso"
            ], 500);
        }
    }
}
