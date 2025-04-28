<?php

namespace App\Http\Services\Services;

use App\Http\Requests\Services\ServiceEditRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Services;

class editService
{
    static public function index(ServiceEditRequest $request, string $id): JsonResponse
    {
        try {
            $service = Services::where('id', $id)->first();
        
            if (!$service) return response()->json(["message" => "Servicio no encontrado"], 404);
            
            $service->service_type = $request->name;
            $service->is_for_elevators = $request->is_elevator;
        
            $service->save();
        
            return response()->json(["message" => 'Se ha editado correctamente'], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Ocurrió un error inesperado al editar el servicio"
            ], 500);
        }
    }
}
