<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use App\Models\Services;


class showService
{
    static public function index(string $id): JsonResponse
    {
        try {
            $servicesDB = Services::select('service_type', 'is_for_elevators')->where('id', $id)->first();

            $service = [          
                'name' => $servicesDB->service_type,               
                'is_elevator' => $servicesDB->is_for_elevators,
            ];
    
            return response()->json($service, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
