<?php

namespace App\Http\Services\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Services;


class getMiniumService
{
    static public function index(): JsonResponse
    {
        $servicesDB = Services::select('id', 'service_type');
        
        $servicesDB = $servicesDB->get();
        
        $services = $servicesDB->map(function ($service) {
            return [
                'id' => $service->id,               
                'name' => $service->service_type,               
            ];
        });

        return response()->json($services, 200);
    }
}
