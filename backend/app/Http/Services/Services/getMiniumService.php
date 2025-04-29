<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use App\Models\Services;


class getMiniumService
{
    static public function index(): JsonResponse
    {
        try {
            $servicesDB = Services::select('id', 'service_type')->get();
        
            $services = $servicesDB->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->service_type,
                ];
            });
        
            return response()->json($services, 200);
        
        } catch (\Exception $e) {    
            return response()->json([
                'message' => 'Ocurrió un error al obtener los servicios'
            ], 500);
        }
    }
}
